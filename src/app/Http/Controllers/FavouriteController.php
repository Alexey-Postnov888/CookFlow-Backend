<?php

namespace App\Http\Controllers;

use App\repositories\FavouriteRepository;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    private FavouriteRepository $favouriteRepository;

    public function __construct(FavouriteRepository $favouriteRepository)
    {
        $this->favouriteRepository = $favouriteRepository;
    }

    public function createFavourite(Request $request, int $recipeId): bool {
        $isSuccess = $this->favouriteRepository->createFavourites($recipeId, $request->sub());
        return $isSuccess;
    }

    public function deleteFavourite(Request $request, int $recipeId): bool {
        return $this->favouriteRepository->deleteFavourites($recipeId,$request->sub());
    }

}
