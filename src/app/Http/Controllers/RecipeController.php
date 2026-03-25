<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * GET /recipes - получение всех рецептов
     */
    public function index()
    {
        //
    }

    /**
     * POST /recipes - создать рецепт
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * GET /recipes/{id} - получение рецепта по id
     */
    public function show(string $id)
    {
        //
    }

    /**
     * PUT /recipes/{id} - изменить рецепт
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * DELETE /recipes/{id} - удалить рецепт
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * GET /recipes/categories/{category-id} - получить список рецептов по категории
     */
    public function byCategory(Request $request, int $categoryId)
    {
        //
    }

    /**
     * GET /recipes/favourites - получение избранного
     */
    public function favourites(Request $request)
    {
        //
    }

    /**
     * GET /recipes/authors/{authorId} - рецепты пользователя
     */
    public function byAuthor(int $authorId)
    {
        //
    }

}
