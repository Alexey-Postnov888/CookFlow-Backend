<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function createUser(Request $request): JsonResponse
    {
        try {
            $this->userService->createUser(
                $request->input('username'),
                $request->input('credentials')['value'],
                $request->input('email'),
                $request->input('firstName'),
                $request->input('lastName')
            );

            $loginResponse = Http::post(
                'http://host.docker.internal:8080/api/login',
                [
                    'username' => $request->input('username'),
                    'password' => $request->input('credentials')['value']
                ]
            );

            if (!$loginResponse->successful()) {
                throw new Exception('Login failed');
            }

            $loginData = $loginResponse->json();

            $userSub = $this->userService->getSubFromJwt($loginData['access_token']);

            $this->userService->changeRole(
                $userSub,
                ['user']
            );

            return response()->json([
                'access_token' => $loginData['access_token'],
                'refresh_token' => $loginData['refresh_token']
            ]);
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function changeRole(Request $request, string $userId): JsonResponse {
        $role = 'admin';
        $hasRole = $request->hasRole($role);

        if ($hasRole) {
            try {
                $this->userService->changeRole(
                    $userId,
                    $request->input('roles')
                );

                return response()->json([
                    'status' => 'success',
                    'message' => 'User roles is changed'
                ]);
            } catch (Exception $e) {
                return response()->json(
                    [
                        'status' => 'error',
                        'error' => $e->getMessage()
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'error' => 'Forbidden'
                ],
                Response::HTTP_FORBIDDEN
            );
        }
    }
}
