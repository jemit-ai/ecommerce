<?php

namespace App\Listeners\OrderPaid;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Order\OrderPaid;
use App\Models\Order\Order;
//use App\Services\EmailService; 

class SendEmail implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
    

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
    }
}
