<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShopReview;
use App\Models\User;
use Illuminate\Http\Request;

class ShopReviewController extends Controller
{
    /**
     * Submit a rating and review for a tailor shop
     */
    public function store(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'order_id' => 'nullable|integer',
        ]);

        $customerId = $request->user()?->id ?? $request->customer_id ?? auth()->id() ?? 1;

        $review = ShopReview::create([
            'shop_id' => $request->shop_id,
            'customer_id' => $customerId,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Recalculate average rating & review count for shop
        $shop = User::find($request->shop_id);
        if ($shop) {
            $avgRating = ShopReview::where('shop_id', $shop->id)->avg('rating');
            $reviewCount = ShopReview::where('shop_id', $shop->id)->count();

            $shop->rating = round($avgRating, 2);
            $shop->review_count = $reviewCount;
            $shop->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your rating & review!',
            'data' => $review
        ]);
    }
}
