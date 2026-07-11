<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    //
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'total',
    ];

    /**
     * Order detail belongs to an order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Order detail belongs to a product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
