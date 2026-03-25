<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title'];

    public static function getAll(): Collection {
        return Category::all();
    }

    public static function getById(int $id): Category {
        return Category::findOrFail($id);
    }

    public static function createCategory(Category $category): bool {
        return $category->save();
    }

    public static function updateCategory(Category $category): bool {
        return $category->save();
    }

    public static function deleteCategory(Category $category): bool {
        return $category->delete();
    }
}
