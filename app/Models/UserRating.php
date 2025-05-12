<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRating extends Model
{
    //
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'rating',
        'rating_datetime'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
