<?php

namespace App\repositories;

use Illuminate\Database\Eloquent\Collection;

interface FavouriteRepository
{
    public function createFavourites(int $recipeId, string $userId): bool;
    public function deleteFavourites(int $recipeId, string $userId): bool;
}
