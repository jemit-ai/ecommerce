<?php

namespace App\Listeners\OrderCancelled;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Order\CancelOrderNotification;
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
         try{
            
            \Log::info('#Cancel Notification handler.....');
            \Log::warning('#user ID Placed $admin = User::find(1);'."File:--->".__FILE__."Line:--->".__LINE__);
            
            $admin = User::find(1);

            if ($admin) {

                $admin->notify(new CancelOrderNotification($event->order));
                \Log::info('#Cancel Notification sent successfully.....');

            }

        }catch(\Exception $e){

            \Log::info(message: $e->getMessage());
            
        }
    }
}
