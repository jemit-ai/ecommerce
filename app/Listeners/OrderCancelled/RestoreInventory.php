<?php

namespace App\Listeners\OrderCancelled;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Order\OrderCancelled;
use App\Models\Order\Order;
use App\Models\Product;
use App\Services\Order\InventoryService;
use App\Jobs\Order\UpdateInventory; 

class RestoreInventory implements ShouldQueue
{
    use InteractsWithQueue;
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
        //
        //UpdateInventory::dispatch($event->order);
        try{ 
            UpdateInventory::dispatch($event->order);
        }catch(\Exception $e){
            \Log::info("Inventory update failed for order {$event->order->id}  {$e->getMessage()}");
        }

    }
}
