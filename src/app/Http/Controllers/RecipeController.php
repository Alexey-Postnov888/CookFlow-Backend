<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\repositories\RecipeRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
{
    private RecipeRepository $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    /**
     * GET /recipes - получение всех рецептов
     */
    public function getRecipes(): JsonResponse
    {
        try
        {
            $recipes = $this->recipeRepository->getRecipes();
            return response()->json([
                "success" => true,
                "recipes" => $recipes
            ], Response::HTTP_OK);
        }
        catch (Exception $e)
        {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * POST /recipes - создать рецепт
     */
    public function postRecipe(Request $request): JsonResponse
    {
        //TODO проверять роль
        try {
            $validated = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'ingredients' => 'required|array',
                'steps' => 'required|array',
                'image_url' => 'required|string',
                'category_id' => 'required|integer',
            ]);

            $validated['author_id'] = $request->sub();

            $recipe = $this->recipeRepository->postRecipe((new Recipe())->fill($validated));

            if ($recipe) {
                return response()->json([
                    "success" => true,
                    'message' => 'Recipe created',],
                    Response::HTTP_CREATED);
            } else {
                return response()->json([
                    "success" => false,
                    'message' => 'Recipe not created',],
                    Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * GET /recipes/{id} - получение рецепта по id
     */
    public function getRecipeById(int $id): JsonResponse
    {
        try
        {
            $recipe = $this->recipeRepository->getRecipeById($id);
            return response()->json([
                "success" => true,
                "recipe" => $recipe
            ], Response::HTTP_OK);
        }
        catch (ModelNotFoundException $e)
        {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
        catch (Exception $e)
        {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * PUT /recipes/{id} - изменить рецепт
     */
    public function updateRecipeById(Request $request, int $id): JsonResponse
    {
        try
        {
            $recipe = $this->recipeRepository->getRecipeById($id);
            $userId = $request->sub();
            $authorId = $recipe->author_id;
            if ($userId != $authorId)
            {
                return response()->json([
                    "success" => false,
                    "message" => "You don't have permission to perform this action"
                ], Response::HTTP_FORBIDDEN);
            }

            $validated = $request->validate([
                'title' => 'sometimes|string',
                'description' => 'sometimes|string',
                'ingredients' => 'sometimes|array',
                'steps' => 'sometimes|array',
                'image_url' => 'sometimes|string',
                'category_id' => 'sometimes|integer',
            ]);

            $newRecipe = (new Recipe())->fill($validated);

            $updatedRecipe = new Recipe();
            $updatedRecipe->fill([
                'title'=>$newRecipe->title ?: $recipe->title,
                'description'=>$newRecipe->description ?: $recipe->description,
                'ingredients'=>$newRecipe->ingredients ?: $recipe->ingredients,
                'steps'=>$newRecipe->steps ?: $recipe->steps,
                'image_url'=>$newRecipe->image_url ?: $recipe->image_url,
                'category_id'=>$newRecipe->category_id ?: $recipe->category_id,
            ]);

            $isDone = $this->recipeRepository->updateRecipe($id, $updatedRecipe);
            if($isDone)
            {
                return response()->json([
                    "success" => true,
                    'message' => 'Recipe updated',
                ], Response::HTTP_OK);
            }
            else
            {
                return response()->json([
                    "success" => false,
                    'message' => 'Recipe not updated',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        }
        catch (ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);

        } catch (ValidationException $e) {
            return response()->json([
                "success" => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * DELETE /recipes/{id} - удалить рецепт
     */
    public function deleteRecipeById(Request $request, int $id): JsonResponse
    {
        try
        {
            $recipe = $this->recipeRepository->getRecipeById($id);
            $authorId = $recipe->author_id;
            $userId = $request->sub();

            if ($authorId != $userId)
            {
                return response()->json([
                    "success" => false,
                    "message" => "You don't have permission to delete this recipe"
                ], Response::HTTP_FORBIDDEN);
            }

            $isDone = $this->recipeRepository->deleteRecipe($id);
            if($isDone)
            {
                return response()->json([
                    "success" => true,
                    "message" => "Deleted recipe ".$id." successfully"
                ], Response::HTTP_NO_CONTENT);
            }
            else
            {
                return response()->json([
                    "success" => false,
                    "message" => "Recipe not deleted"
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (Exception $e)
        {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * GET /recipes/categories/{category-id} - получить список рецептов по категории
     */
    public function getRecipesByCategory(int $categoryId): JsonResponse
    {
        try
        {
            $recipes = $this->recipeRepository->getRecipesByCategoryId($categoryId);
            return response()->json([
                "success" => true,
                "recipes" => $recipes
            ], Response::HTTP_OK);
        }
        catch (Exception $e)
        {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * GET /recipes/favourites - получение избранного
     */
    public function getFavourites(Request $request): JsonResponse
    {
        try
        {
            $userId = $request->sub();
            $recipes = $this->recipeRepository->getFavourites($userId);
            return response()->json([
                "success" => true,
                "recipes" => $recipes
            ],Response::HTTP_OK);
        }
        catch (Exception $e)
        {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * GET /recipes/authors/{authorId} - рецепты пользователя
     */
    public function getRecipeByAuthor(string $authorId): JsonResponse
    {
        try
        {
            $recipes = $this->recipeRepository->getRecipeByAuthor($authorId);
            return response()->json([
                    "success" => true,
                    "recipes" => $recipes
            ],Response::HTTP_OK);
        }
        catch (Exception $e)
        {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
