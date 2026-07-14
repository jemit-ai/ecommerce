<?php

namespace App\Jobs\Order;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order\Order;
use App\Services\Order\InvoiceService;

class GenerateInvoice implements ShouldQueue
{

    use Queueable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(InvoiceService $invoiceService): void
    {
        //
       try{
          $invoiceService->generate($this->order);
       }catch(\Exception $e){
          \Log::info("Invoice generation failed for order {$this->order->id}  {$e->getMessage()}");
       }


    }
}
