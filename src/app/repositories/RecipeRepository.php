<?php
namespace App\repositories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
interface RecipeRepository
{
    public function getRecipes(): Collection;
    public function getRecipeById(int $recipeId): Recipe;
    public function getRecipesByCategoryId(int $categoryId): Collection;
    public function getRecipesByCategoryTitle(string $categoryTitle): Collection;
    public function getFavourites(string $userId): Collection;
    public function getRecipeByAuthor (string $authorId): Collection;
    public function postRecipe(Recipe $recipe): bool;
    public function updateRecipe(int $recipeId, Recipe $recipe): bool;
    public function deleteRecipe(int $recipeId): bool;
}
