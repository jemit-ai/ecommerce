<?php

namespace App\Listeners\OrderPlaced;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Order\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use App\Services\Order\InventoryService;
use App\Jobs\Order\UpdateInventory;

class UpdateInventoryListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public InventoryService $inventoryService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        
        \Log::info('Inventory Updated Successfully'); 
        \Log::info($event->order->id); 
        \Log::info($event->order->order_number); 
        //\Log::info($event->order->order_details); 
        \Log::info($event->order->order_status); 
        \Log::info($event->order->user_id); 
        \Log::info($event->order->payment_method); 
        \Log::info($event->order->payment_id);
        
        UpdateInventory::dispatch($event->order);


    }
}
