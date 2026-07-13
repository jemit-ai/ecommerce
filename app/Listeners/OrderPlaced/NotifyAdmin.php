<?php

namespace App\Listeners\OrderPlaced;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Order\NewOrderNotification;
use App\Services\Order\OrderService;
use App\Models\User;

class NotifyAdmin implements ShouldQueue
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
        //
        try{

            \Log::info('#Notification handler.....');
            $admin = User::find(1);
            if ($admin) {
                $admin->notify(new NewOrderNotification($event->order));
            }

        }catch(\Exception $e){
            \Log::info(message: $e->getMessage());
        }

        

    }
}
