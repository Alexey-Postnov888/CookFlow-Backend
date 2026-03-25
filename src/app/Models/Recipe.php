<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image_url',
        'description',
        'ingredients',
        'steps',
        'author_id',
        'category_id',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'steps' => 'array',
    ];

    public static function getAll(): Collection {

        return Recipe::all();
    }

    public static function getById(int $id): Recipe {
        return Recipe::findOrFail($id);
    }

    public static function getFavouriteRecipes(string $userId): Collection {
        return Recipe::join('favourites', 'recipes.id', '=', 'favourites.recipe_id')
            ->where('favourites.user_id', $userId)
            ->select('recipes.*')
            ->get();
    }

    public static function getUserRecipes(string $userId): Collection {

        return Recipe::where('recipes.author_id', $userId)
            ->select('recipes.*')
            ->get();
    }

    public static function getCategoryRecipesById(int $categoryId): Collection {

        return Recipe::where('recipes.category_id', $categoryId)
            ->select('recipes.*')
            ->get();
    }

    public static function getCategoryRecipesByTitle(string $categoryTitle): Collection {

        return Recipe::join('categories', 'recipes.category_id', '=', 'categories.id')
            ->where('categories.title', $categoryTitle)
            ->select('recipes.*')
            ->get();
    }

    public static function createRecipe(Recipe $recipe): bool {
        return $recipe->save();
    }

    public static function updateRecipe(Recipe $recipe): bool {
        return $recipe->save();
    }

    public static function deleteRecipeById(int $recipeId): bool {
        $recipe = Recipe::find($recipeId);
        if (!$recipe) {
            return false;
        }
        else {
            return $recipe->delete();
        }
    }
}
