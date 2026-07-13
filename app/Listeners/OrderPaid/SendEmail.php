<?php

namespace App\Listeners\OrderPlaced;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Order\OrderPlaced;
use App\Models\Order\Order;
use App\Services\EmailService; 

class SendEmail
{
    /**
     * Create the event listener.
     */
    public function __construct(public EmailService $emailService)
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
