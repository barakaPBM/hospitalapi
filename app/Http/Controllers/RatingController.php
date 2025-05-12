<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\UserRating;
use Carbon\Carbon;
use App\Http\Requests\UserRatingRequest;

class RatingController extends Controller
{
    //Method for creating a rating
    public function store(UserRatingRequest $request)
    {
        $data = $request->validated();

        $data['rating_datetime'] = now();

        $rating = UserRating::updateOrCreate(
            ['user_id' => $data['user_id'], 'product_id' => $data['product_id']],
            $data
        );

        return response()->json([
            'message' => 'Rating submitted successfully.',
            'data' => $rating,
        ]);
    }

    //Update rating
    public function update(Request $request, $id)
    {
        $rating = UserRating::findOrFail($id);

        $request->validate([
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $ratingData = $request->only(['rating']);
        $ratingData['rating_datetime'] = now();

        $rating->update($ratingData);

        return response()->json([
            'message' => 'Rating updated successfully.',
            'data' => $rating,
        ]);
    }

    //delete rating
    public function destroy($id)
    {
        $rating = UserRating::findOrFail($id);
        $rating->delete();

        return response()->json(['message' => 'Rating deleted successfully']);
    }

    //product list
    public function product_list(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;

        // Get products with their average rating, user rating, time passed, and active time
        $products = Product::with([
            'ratings' => function ($query) {
                $query->selectRaw('product_id, AVG(rating) as average_rating');
                $query->groupBy('product_id');
            }
        ])
            ->get()
            ->map(function ($product) use ($userId) {
                // Calculate average rating of the product
                $product->ratings_count = $product->ratings->avg('rating');

                // Get the user's rating for the product
                $userRating = UserRating::where('user_id', $userId)
                    ->where('product_id', $product->id)
                    ->first();

                $product->user_rating = $userRating ? $userRating->rating : null;

                // Calculate time passed in minutes
                $ratingDatetime = $userRating ? Carbon::parse($userRating->rating_datetime) : null;
                $product->time_passed = $ratingDatetime ? $ratingDatetime->diffInMinutes(now()) : null;

                // Check if the product is active or inactive based on time_passed
                $product->active_time = $product->time_passed && $product->time_passed > 30 ? 'active' : 'inactive';

                return $product;
            });

        return response()->json($products);



    }
}
