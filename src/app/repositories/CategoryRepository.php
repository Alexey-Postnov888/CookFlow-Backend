<?php

namespace App\repositories;

use Illuminate\Database\Eloquent\Collection;

interface CategoryRepository
{
    public function getCategories(): Collection;
    public function postCategory(string $categoryBody): bool;
    public function deleteCategory(int $categoryId): bool;
    public function updateCategory(int $categoryId, string $newCategory): bool;
}
