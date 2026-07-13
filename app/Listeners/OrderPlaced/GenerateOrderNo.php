<?php

namespace App\Listeners\OrderPlaced;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\Order\OrderPlaced;
use App\Services\Order\OrderService;
use Exception; 

class GenerateOrderNo implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(public OrderService $orderService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
        try{

            \Log::info("#### Order number generation started ####");
            $this->orderService->generateOrderNo($event->order);

        }catch(Exception $e){
            
            \Log::info("Order number generation failed for order {$event->order->id}  {$e->getMessage()}");

        }
            
    }
}
