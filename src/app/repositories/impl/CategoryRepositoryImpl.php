<?php

namespace App\repositories\impl;

use App\Models\Category;
use App\repositories\CategoryRepository;
use Ramsey\Collection\Collection;


class CategoryRepositoryImpl implements CategoryRepository{


    public function getCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return Category::all();
    }

    public function postCategory(string $categoryBody, string $userId): bool
    {
        $category = new Category();
        //$category->user_id = $userId;
        $category->title = $categoryBody;
        return $category->save();
    }

    public function deleteCategory(int $categoryId, string $userId): bool
    {
        $category = Category::where("id", $categoryId)
            ->first();
        if ($category) {
            return $category->delete();
        } else {
            return false;
        }
    }

    public function updateCategory(int $categoryId, string $newCategory, string $userId): bool
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
