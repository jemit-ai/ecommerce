<?php

namespace App\Listeners\OrderPlaced;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Order\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use App\Services\Order\InvoiceService; 
use App\Jobs\Order\GenerateInvoice;

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

        \Log::info('Invoice listener triggerd.');
        GenerateInvoice::dispatch($event->order);


    }
}
