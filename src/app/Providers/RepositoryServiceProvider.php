<?php

namespace App\Providers;

use App\repositories\CommentRepository;
use App\repositories\FavouriteRepository;
use App\repositories\impl\CommentRepositoryImpl;
use App\repositories\impl\FavouriteRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CommentRepository::class, CommentRepositoryImpl::class);
        $this->app->bind(FavouriteRepository::class, FavouriteRepositoryImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
