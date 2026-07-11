<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
     protected $fillable = [
        'user_id',
        'order_number',
        'payment_method',
        'payment_id',
        'order_status',
    ];

    /**
     * Order belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order has many order details.
     */
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    
}
