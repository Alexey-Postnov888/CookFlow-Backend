<?php

namespace App\Services\Impl;

use App\Services\UserService;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Http;

class UserServiceImpl implements UserService
{
    private string $keycloakUrl;
    private string $realm;
    private string $clientId;
    private string $clientSecret;

    public function __construct()
    {
        $this->keycloakUrl = (string)config('main.keycloak_url');
        $this->realm = (string)config('main.realm');
        $this->clientId = (string)config('main.client_id');
        $this->clientSecret = (string)config('main.client_secret');
    }
    public function getAdminToken(): string
    {
        $adminResponse = Http::asForm()->post($this->keycloakUrl . '/realms/' . $this->realm . '/protocol/openid-connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        return $adminResponse->json()['access_token'];
    }

    public function createUser(string $username, string $password, string $email, string $firstName, string $lastName)
    {
        $adminToken = $this->getAdminToken();

        $response = Http::withToken($adminToken)->post($this->keycloakUrl.'/admin/realms/'.$this->realm.'/users', [
            'username' => $username,
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'enabled' => true,
            'credentials' => [
                [
                    'type' => 'password',
                    'value' => $password,
                    'temporary' => false
                ]
            ]
        ]);

        return $response->json();
    }

    public function changeRole(string $userId, array $roleNames): void
    {
        if (empty($roleNames)) {
            return;
        }

        $adminToken = $this->getAdminToken();

        $rolesResponse = Http::withToken($adminToken)
            ->get($this->keycloakUrl.'/admin/realms/'.$this->realm.'/roles');

        if (!$rolesResponse->successful()) {
            throw new Exception('Failed to change roles.');
        }

        $roles = $rolesResponse->json();

        $targetRoles = [];

        foreach ($roles as $role) {
            if (in_array($role['name'], $roleNames)) {
                $targetRoles[] = [
                    'id' => $role['id'],
                    'name' => $role['name'],
                ];
            }
        }

        if (empty($targetRoles)) {
            throw new Exception('Roles not found');
        }

        $assignResponse = Http::withToken($adminToken)
            ->post(
                $this->keycloakUrl.'/admin/realms/'.$this->realm.'/users/'.$userId.'/role-mappings/realm',
                $targetRoles
            );

        if (!$assignResponse->successful()) {
            throw new Exception('Failed to assign roles.');
        }
    }

    private function getPublicKeycloakKey(): ?string
    {
        $response = Http::get($this->keycloakUrl . '/realms/' . $this->realm . '/protocol/openid-connect/certs');

        if (!$response->ok()) {
            return null;
        }

        $keys = $response->json()['keys'] ?? [];

        foreach ($keys as $key) {
            if (($key['use'] ?? '') === 'sig') {
                $x5c = $key['x5c'][0] ?? null;
                if (!$x5c) {
                    return null;
                }

                $publicKey = "-----BEGIN CERTIFICATE-----\n" .
                    chunk_split($x5c, 64, "\n") .
                    "-----END CERTIFICATE-----\n";

                return $publicKey;
            }
        }

        return null;
    }

    public function getSubFromJWT(string $jwt): ?string
    {
        $publicKey = $this->getPublicKeycloakKey();

        if ($publicKey) {
            $decoded = JWT::decode($jwt, new Key($publicKey, 'RS256'));
            $sub = $decoded->sub ?? null;

            return $sub;
        }

        return null;
    }
}
