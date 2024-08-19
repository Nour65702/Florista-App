<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductResource;
use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductLikeController extends Controller
{
    public function likeOrUnlike(Request $request, $productId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $like = Like::where('user_id', $request->user_id)
            ->where('product_id', $productId)
            ->first();

        if ($like) {

            $like->delete();

            $message = 'Product like removed';
        } else {

            Like::create([
                'user_id' => $request->user_id,
                'product_id' => $productId,
                'is_liked' => true,
            ]);

            $message = 'Product liked successfully';
        }

        $product = Product::findOrFail($productId);
        $likesCount = $product->likesCount();


        return ApiResponse::success([
            'message' => $message,
            'likes' => $likesCount,

        ]);
    }

    public function isProductLiked($productId)
    {
        $userId = Auth::id();

        $like = Like::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        return ApiResponse::success([
            'is_liked' => $like ? true : false,
        ]);
    }

    public function getLikedProducts()
    {
        $userId = Auth::id();

        $likedProducts = Product::whereHas('likes', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return ApiResponse::success([
            'liked_products' => ProductResource::collection($likedProducts),
        ]);
    }
}
