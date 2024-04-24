<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\StoreReviewFormRequest;
use App\Http\Resources\Products\ReviewResource;
use App\Models\Product;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(StoreReviewFormRequest $request)
    {
        $validatedData = $request->validated();

        $review = Review::create($validatedData);
        $productId = $validatedData['product_id'];
        $averageRate = Review::where('product_id', $productId)->avg('rate');
        Product::where('id', $productId)->update(['rate' => $averageRate]);

        return ApiResponse::success([
            'message' => 'Review Added successfully.',
            'review' => ReviewResource::make($review),
        ]);
    }

    public function index()
    {
        $reviews = Review::all();
        return ApiResponse::success([

            'reviews' => ReviewResource::collection($reviews)
        ]);
    }
}
