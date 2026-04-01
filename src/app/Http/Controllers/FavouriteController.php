<?php

namespace App\Http\Controllers;

use App\repositories\FavouriteRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FavouriteController extends Controller
{
    private FavouriteRepository $favouriteRepository;

    public function __construct(FavouriteRepository $favouriteRepository)
    {
        $this->favouriteRepository = $favouriteRepository;
    }

    /**
     * POST - создать категорию
     * @param int $recipeId Id рецепта, который нужно добавить в избранное
     * @param Request $request Запрос
     */
    public function createFavourite(Request $request, int $recipeId): JsonResponse {
        try
        {
            $userId = $request->sub();
            $isSuccess = $this->favouriteRepository->createFavourites($recipeId, $userId);

            if($isSuccess){
                return response()->json([
                    'success' => true,
                    'message' => 'Recipe added to favourites'
                ], Response::HTTP_CREATED);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Recipe not added to favourites'
                ], Response::HTTP_BAD_REQUEST);
            }

        }
        catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * DELETE - удалить категорию
     * @param int $recipeId Id рецепта, у которого надо убрать избранное
     * @param Request $request Запрос
     * */
    public function deleteFavourite(Request $request, int $recipeId): JsonResponse {
        try{
            $userId = $request->sub();
            $isSuccess = $this->favouriteRepository->deleteFavourites($recipeId, $userId);
            if($isSuccess){
                return response()->json([
                    'success' => true,
                    'message' => 'Recipe deleted from favourites'
                ], Response::HTTP_NO_CONTENT);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Recipe not deleted from favourites'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception  $exception)
        {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
