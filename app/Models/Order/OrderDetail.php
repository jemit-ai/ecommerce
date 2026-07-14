<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class OrderDetail extends Model
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
