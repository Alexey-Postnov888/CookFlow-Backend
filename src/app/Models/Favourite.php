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

    public static function deleteFavourite(Favourite $favourite): bool {
        return $favourite->delete();
    }
}
