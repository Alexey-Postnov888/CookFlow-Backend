<?php

namespace App\repositories\impl;;

use App\Models\Comment;
use App\Models\Recipe;
use App\repositories\RecipeRepository;
use Illuminate\Database\Eloquent\Collection;
use App\repositories\CommentRepository;

class RecipeRepositoryImpl implements RecipeRepository
{

    public function getRecipes(): Collection
    {
        return Recipe::all();
    }

    public function getRecipeById(int $recipeId): Recipe
    {
        return Recipe::findOrFail($recipeId);
    }

    public function getRecipesByCategoryId(int $categoryId): Collection
    {
        return Recipe::where('recipes.category_id', $categoryId)
            ->select('recipes.*')
            ->get();
    }

    public function getRecipesByCategoryTitle(string $categoryTitle): Collection
    {
        return Recipe::join('categories', 'recipes.category_id', '=', 'categories.id')
            ->where('categories.title', $categoryTitle)
            ->select('recipes.*')
            ->get();
    }

    public function getFavourites(string $userId): Collection
    {
        return Recipe::join('favourites', 'recipes.id', '=', 'favourites.recipe_id')
            ->where('favourites.user_id', $userId)
            ->select('recipes.*')
            ->get();
    }

    public function getRecipeByAuthor(string $authorId): Collection
    {
        return Recipe::where('recipes.author_id', $authorId)
            ->select('recipes.*')
            ->get();
    }

    public function postRecipe(Recipe $recipe): bool
    {
        return $recipe->save();
    }

    public function updateRecipe(int $recipeId, Recipe $recipe): bool
    {
        return $recipe->save();
    }

    public function deleteRecipe(int $recipeId): bool
    {
        $recipe = Recipe::find($recipeId);
        if (!$recipe) {
            return false;
        }
        else {
            return $recipe->delete();
        }
    }
}
