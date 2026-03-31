<?php

namespace App\repositories;

use Illuminate\Database\Eloquent\Collection;

interface CategoryRepository
{
    public function getCategories(): Collection;
    public function postCategory(string $categoryBody, string $userId): bool;
    public function deleteCategory(int $categoryId, string $userId): bool;
    public function updateCategory(int $categoryId, string $newCategory, string $userId): bool;
}
