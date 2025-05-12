<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRating;
use App\Models\Product;
use Carbon\Carbon;

class UserRatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::all();
        $products = Product::all();

        // Assign random ratings
        foreach ($users as $user) {
            // Let each user rate 3 random products
            $ratedProducts = $products->random(min(3, $products->count()));

            foreach ($ratedProducts as $product) {
                UserRating::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'rating' => rand(1, 5), // random rating between 1 and 5
                        'rating_datetime' => Carbon::now()->subMinutes(rand(0, 60)), // within last hour
                    ]
                );
            }
        }

    }
}
