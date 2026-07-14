<?php

namespace App\Listeners\OrderCancelled;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Order\OrderTimelineService;


class CreateTimeline implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct(public OrderTimelineService $orderTimelineService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        try{
            $this->orderTimelineService->create($event->order);
        }catch(\Exception $e){
            \Log::info("Timeline creation failed for order {$event->order->id}  {$e->getMessage()}");
        }
        
    }
}
