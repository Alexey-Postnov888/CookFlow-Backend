<?php

namespace App\Services;

use Illuminate\Http\Request;

interface UserService {
    public function getAdminToken(): string;
    public function createUser(string $username, string $password, string $email, string $firstName, string $lastName);
    public function changeRole(string $userId, array $roleNames): void;
    public function getSubFromJWT(string $jwt): ?string;
}
