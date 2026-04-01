<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\repositories\CategoryRepository;
use Nette\Schema\ValidationException;

class CategoryController extends Controller
{

    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * GET recipes/categories - получить все категории
     */
    public function getCategories(): JsonResponse {
        try{
            $categories = $this->categoryRepository->getCategories();

            return response()->json([
                'success' => true,
                'categories' => $categories
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * POST recipes/categories - создать категорию
     * @param Request $request Запрос
     */
    public function postCategory(Request $request):JsonResponse{
        try{
            if(!$request->hasRole('admin')){
                return response()->json([
                    'success' => false,
                    'message' => "Forbidden: You do not have admin permissions"
                ], Response::HTTP_FORBIDDEN);
            }

            $validated = $request->validate([
                "categoryBody" => "required|string|max:255"
            ]);
            $userId = $request->sub();

            if (!$userId){
                return response()->json([
                    'success' => false,
                    'message' => "You must be logged in"
                ], Response::HTTP_UNAUTHORIZED);
            }

            $isSuccess = $this->categoryRepository->postCategory($request['categoryBody']);

            if ($isSuccess){
                return response()->json([
                    'success' => true,
                    'message' => "Category has been created"
                ], Response::HTTP_CREATED);
            }

            return response()->json([
                'success' => false,
                'message' => "Could not create category"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        catch(ValidationException $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        catch(Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * DELETE recipes/categories/{categoryId}- удалить категорию
     * @param Request $request Запрос
     * @param int $categoryId Id категории, которую нужно удалить
     */
    public function deleteCategory(Request $request, int $categoryId): JsonResponse{
        try{
            if(!$request->hasRole('admin')){
                return response()->json([
                    'success' => false,
                    'message' => "Forbidden: You do not have admin permissions"
                ], Response::HTTP_FORBIDDEN);
            }

            $userId = $request->sub();
            if (!$userId){
                return response()->json([
                    'success' => false,
                    'message' => "You must be logged in"
                ], Response::HTTP_UNAUTHORIZED);
            }

            $isSuccess = $this->categoryRepository->deleteCategory($categoryId);
            if ($isSuccess){
                return response()->json([
                    'success' => true,
                    'message' => "Category has been deleted"
                ], Response::HTTP_OK);
            }

            return response()->json([
                'success' => false,
                'message' => "Category not found or access denied"
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * UPDATE recipes/categories/{categoryId} - обновить категорию
     * @param Request $request Запрос
     * @param int $categoryId Id категории, которую надо обновить
     */
    public function updateCategory(Request $request, int $categoryId): JsonResponse{
        try{
            if(!$request->hasRole('admin')){
                return response()->json([
                    'success' => false,
                    'message' => "Forbidden: You do not have admin permissions"
                ], Response::HTTP_FORBIDDEN);
            }

            $validated = $request->validate([
                "categoryBody" => "required|string|max:255"
            ]);

            $userId = request()->sub();
            if (!$userId){
                return response()->json([
                    'success' => false,
                    'message' => "You must be logged in"
                ], Response::HTTP_UNAUTHORIZED);
            }

            $isSuccess = $this->categoryRepository->updateCategory($categoryId,$request['categoryBody']);
            if ($isSuccess){
                return response()->json([
                    'success' => true,
                    'message' => "Category has been updated"
                ], Response::HTTP_OK);
            }

            return response()->json([
                'success' => false,
                'message' => "Category not found or access denied"
            ], Response::HTTP_NOT_FOUND);
        }
        catch(ValidationException $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
