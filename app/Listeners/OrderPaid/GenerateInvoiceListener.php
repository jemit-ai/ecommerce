<?php

namespace App\Listeners\OrderPlaced;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Order\OrderPlaced;
use App\Models\Order\Order;
use App\Models\Order\Product;
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
        try{
            GenerateInvoice::dispatch($event->order);
        }catch(Exception $e){
            \Log::info("Invoice generation failed for order {$event->order->id}  {$e->getMessage()}");
        }

    }
}
