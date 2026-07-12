<?php

namespace App\Jobs\Order;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Services\Order\InventoryService;

class UpdateInventory implements ShouldQueue
{
    use Queueable, InteractsWithQueue, Queueable, SerializesModels;
    

    /**
     * Create a new job instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(InventoryService $inventoryService): void
    {
        //
        $inventoryService->deductStock($this->order);
        \Log::info("Inventory updated for order {$this->order->id}");

    }
}
