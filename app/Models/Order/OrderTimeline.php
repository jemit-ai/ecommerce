<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderTimeline extends Model
{
    //

    protected $fillable = [
        'order_id',
        'user_id',
        'status',
        'title',
        'description',
        'created_by',
        'event_time',
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
