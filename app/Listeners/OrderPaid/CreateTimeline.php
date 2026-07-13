<?php

namespace App\Listeners\OrderPlaced;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Order\OrderService;

class CreateTimeline implements ShouldQueue
{
    use InteractsWithQueue;

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
        try{

            $this->orderService->createTimeLine($event->order);

        }catch(\Exception $e){

            \Log::info("Timeline creation failed for order {$event->order->id}  {$e->getMessage()}");
        }
        
    }
}
