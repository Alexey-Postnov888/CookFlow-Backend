<?php

namespace App\repositories\impl;

use App\Models\Favourite;
use App\repositories\FavouriteRepository;

class FavouriteRepositoryImpl implements FavouriteRepository {
    public function createFavourites(int $recipeId, string $userId): bool{
        if (Favourite::where('recipe_id', $recipeId)
            ->where('user_id', $userId)
            ->exists())
        {
            return false;
        }

        $favourite = new Favourite();
        $favourite->recipe_id = $recipeId;
        $favourite->user_id = $userId;
        $favourite->created_at = now();
        return $favourite->save();
    }
    public function deleteFavourites(int $recipeId, string $userId):bool{
        $favourite = Favourite::where('recipe_id', $recipeId)
            ->where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->first();

        if ($favourite) {
            return $favourite->delete();
        } else {
            return false;
        }
    }

}
