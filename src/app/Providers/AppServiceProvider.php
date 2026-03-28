<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Request::macro('sub', function () {
            return $this->attributes->get('keycloak_id');
        });

        Request::macro('hasRole', function ($role) {
            $roles = $this->attributes->get('keycloak_roles');
            return in_array($role, $roles);
        });
    }
}
