<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Categories\CategoryResource;
use App\Models\Category;


class CategoryController extends Controller
{

    public function index()
    {
        $category = Category::with('children.collections.products')->get();
        return ApiResponse::success([
            'categories' => $category
        ]);
    }


    public function show($id)
    {
        $category = Category::findOrfail($id)->loadMissing('collections.products');
        return ApiResponse::success([

            'category' => CategoryResource::make($category),
        ]);
    }
}
