<?php

namespace App\Providers;

use App\repositories\CommentRepository;
use App\repositories\impl\CommentRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CommentRepository::class, CommentRepositoryImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
