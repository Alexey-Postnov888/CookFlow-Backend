<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class KeycloakAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $keycloakUrl = config('main.keycloak_url');
        $realm = config('main.realm');
        $clientId = config('main.client_id');
        $clientSecret = config('main.client_secret');

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $respose = Http::withToken($token)
            ->get($keycloakUrl.'/realms/'.$realm.'/protocol/openid-connect/userinfo');

        if ($respose->failed()) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $userData = $respose->json();

        $sub = $userData['sub'];
        $name = $userData['name'];
        $email = $userData['email'];
        $roles = $userData['realm_access']['roles'];

        $request->attributes->add([
            'keycloak_id' => $sub,
            'keycloak_name' => $name,
            'keycloak_email' => $email,
            'keycloak_roles' => $roles,
        ]);

        return $next($request);
    }
}
