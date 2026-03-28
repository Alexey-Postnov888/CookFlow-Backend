<?php

namespace App\Providers;

use App\Http\Controllers\RecipeController;
use App\repositories\CommentRepository;
use App\repositories\impl\CommentRepositoryImpl;
use App\repositories\impl\RecipeRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CommentRepository::class, CommentRepositoryImpl::class);
        $this->app->bind(RecipeController::class, RecipeRepositoryImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
