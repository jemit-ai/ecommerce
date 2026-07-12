<?php

namespace App\Listeners\OrderPlaced;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Order\OrderPlaced;
use App\Models\Order;
use App\Services\Order\InvoiceService; 

class GenerateInvoiceListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public InvoiceService $invoiceService)
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
