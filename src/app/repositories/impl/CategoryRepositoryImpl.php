<?php

namespace App\repositories\impl;

use App\Models\Category;
use App\repositories\CategoryRepository;
use Ramsey\Collection\Collection;


class CategoryRepositoryImpl implements CategoryRepository{

    /**
     * GET - получить все категории
     */
    public function getCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return Category::all();
    }
    /**
     * POST - создать категорию
     * @param string $categoryBody Название категории
     */
    public function postCategory(string $categoryBody): bool
    {
        $category = new Category();
        $category->title = $categoryBody;
        return $category->save();
    }
    /**
     * DELETE - удалить категорию
     * @param int $categoryId Id категории, которую нужно удалить
     */
    public function deleteCategory(int $categoryId): bool
    {
        $category = Category::where("id", $categoryId)
            ->first();
        if ($category) {
            return $category->delete();
        } else {
            return false;
        }
    }
    /**
     * UPDATE - обновить категорию
     * @param int $categoryId Id категории, которую надо обновить
     * @param string $newCategory Новое название категории
     */
    public function updateCategory(int $categoryId, string $newCategory): bool
    {
        $category = Category::where("id", $categoryId)
            ->first();

        if ($category) {
            $category->title = $newCategory;
            return $category->save();
        } else {
            return false;
        }
    }
}
