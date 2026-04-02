<?php

namespace App\repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepository
{
    public function getCategoryById(int $categoryId): Category;
    public function getCategories(): Collection;
    public function postCategory(string $categoryBody): bool;
    public function deleteCategory(int $categoryId): bool;
    public function updateCategory(int $categoryId, string $newCategory): bool;
}
