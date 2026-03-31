<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\repositories\CategoryRepository;

class CategoryController extends Controller
{

    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories(){
        $categories = $this->categoryRepository->getCategories();
        return $categories;
    }

    public function postCategory(Request $request):bool{
        $isSuccess = $this->categoryRepository->postCategory($request['categoryBody'],$request->sub());
        return $isSuccess;
    }

    public function deleteCategory(Request $request, $categoryId): bool{
        return $this->categoryRepository->deleteCategory($categoryId, $request->sub());
    }

    public function updateCategory(Request $request, int $categoryId): bool{
        return  $this->categoryRepository->updateCategory($categoryId, $request['categoryBody'],$request->sub());
    }
}
