<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductImage;


class Product extends Model
{
    //

    protected $fillable = [
        'name',
        'sku',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
