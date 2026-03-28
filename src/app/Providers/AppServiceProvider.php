<?php

namespace App\Providers;

use App\Services\Impl\UserServiceImpl;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserService::class, UserServiceImpl::class);
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
