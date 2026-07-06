<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(name="Categories")
 */
class CategoryController extends Controller
{
    /**
     * @OA\Get(path="/api/v1/categories", tags={"Categories"}, summary="List categories")
     */
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(
            Category::query()->where('is_active', true)->with('children')->orderBy('name')->get()
        );
    }

    /**
     * @OA\Get(path="/api/v1/categories/{category}", tags={"Categories"}, summary="Show a category")
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category->load(['parent', 'children']));
    }
}
