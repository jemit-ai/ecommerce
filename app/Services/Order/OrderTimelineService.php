<?php
namespace App\Services\Order;

use App\Models\Order\Order;
use App\Models\Order\OrderDetail;
use App\Models\Product;
use App\Models\Order\OrderTimeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use App\Events\Order\OrderPlaced;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderCancelled;
use App\Enum\OrderStatus;
use App\Services\Order\InventoryService;


use Exception;

class OrderTimelineService
{

    public function __construct(public InventoryService $inventoryService){}
    
    private const TIMELINE_EVENTS = [ 

        OrderStatus::PENDING->value => [
            'title' => 'Order Placed',
            'description' => 'Your order has been placed successfully.',
        ],

        OrderStatus::CONFIRMED->value => [
            'title' => 'Order Confirmed',
            'description' => 'Your order has been confirmed.',
        ],

        OrderStatus::PROCESSING->value => [
            'title' => 'Processing',
            'description' => 'Your order is being processed.',
        ],

        OrderStatus::SHIPPED->value => [
            'title' => 'Order Shipped',
            'description' => 'Your order has been shipped.',
        ],

        OrderStatus::OUT_FOR_DELIVERY->value => [
            'title' => 'Out For Delivery',
            'description' => 'Your order is out for delivery.',
        ],

        OrderStatus::DELIVERED->value => [
            'title' => 'Delivered',
            'description' => 'Your order has been delivered.',
        ],

        OrderStatus::CANCELLED->value => [
            'title' => 'Cancelled',
            'description' => 'Your order has been cancelled.',
        ],

        OrderStatus::RETURNED->value => [
            'title' => 'Returned',
            'description' => 'Your order has been cancelled.',
        ],
        
    ];

}