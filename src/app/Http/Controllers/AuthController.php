<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $keycloakUrl = config('main.keycloak_url');
        $realm = config('main.realm');
        $clientId = config('main.client_id');
        $clientSecret = config('main.client_secret');

        try {
            $response = Http::asForm()->post($keycloakUrl . '/realms/' . $realm . '/protocol/openid-connect/token', [
                'grant_type' => 'password',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'username' => $request->username,
                'password' => $request->password,
                'scope' => 'openid',
            ]);
        } catch (ConnectionException $e) {
            return response()->json([
                'error' => 'Invalid credentials.',
                301
            ]);
        }

        return $response->json();
    }
}
