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
        'author_id'
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

    public static function getFavouriteRecipes(int $userId): Collection {
        return Recipe::join('favourites', 'recipes.recipe_id', '=', 'favourites.recipe_id')
            ->where('favourites.user_id', $userId)
            ->select('recipes.*')
            ->get();
    }

    public static function getUserRecipes(int $userId): Collection {

        return Recipe::join('users', 'recipes.author_id', '=', 'users.id')
            ->where('recipes.author_id', $userId)
            ->select('recipes.*')
            ->get();
    }

    public static function getCategoryRecipesById(int $categoryId): Collection {

        return Recipe::join('category_recipes', 'recipes.id', '=', 'category_recipes.recipe_id')
            ->where('category_recipes.category_id', $categoryId)
            ->select('recipes.*')
            ->get();
    }

    public static function getCategoryRecipesByTitle(string $categoryTitle): Collection {

        return Recipe::join('category_recipes', 'recipes.id', '=', 'category_recipes.recipe_id')
            ->join('categories', 'category_recipes.category_id', '=', 'categories.id')
            ->where('category.category_title', $categoryTitle)
            ->select('recipes.*')
            ->get();
    }

    public static function createRecipe(Recipe $recipe): bool {
        return $recipe->save();
    }

    public static function updateRecipe(Recipe $recipe): bool {
        return $recipe->save();
    }

    public static function deleteRecipe(Recipe $recipe): bool {
        return $recipe->delete();
    }
}
