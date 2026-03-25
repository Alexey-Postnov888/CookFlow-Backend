<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $fillable = [
        'user_id',
        'recipe_id',
    ];

    public static function addFavourite(Favourite $favourite): bool {
        return $favourite->save();
    }

    public static function deleteFavourite(int $recipeId, string $userId): bool {
        $favourite = Favourite::where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->first();

        if (!$favourite) {
            return false;
        }
        else {
            return $favourite->delete();
        }
    }
}
