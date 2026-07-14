<?php

namespace App\Listeners\OrderPaid;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Order\OrderPaid;
use App\Models\Order\Order;

use App\Models\Order\OrderDetail;
use App\Models\Product;

use App\Services\Order\InvoiceService; 
use App\Jobs\Order\GenerateInvoice;


class CreateInvoice implements ShouldQueue
{
    use InteractsWithQueue;
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
            \Log::info('Invoice generation started for order ' . $event->order->id);
            GenerateInvoice::dispatch($event->order);
        }catch(\Exception $e){
            \Log::info("Invoice generation failed for order {$event->order->id}  {$e->getMessage()}");
        }

    }
}
