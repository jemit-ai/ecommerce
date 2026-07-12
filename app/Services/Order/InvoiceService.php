<?php
namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;

class InvoiceService{
    
    public function generate(Order $order):string{

        \Log::info("####Invoice service started ####");

        \Log::info($order);

        try{

            $order->load([
                'user',
                'details.product'
            ]);

            $pdf = Pdf::loadView(
                'pdf.invoice',
                [
                    'order' => $order,
                ]
            );


            $fileName = "invoice-{$order->order_number}.pdf";

            $path = "invoices/{$fileName}";

            Storage::disk('public')->put(
                $path,
                $pdf->output()
            );

        }catch(Exception $e){

            \Log::info($e->getMessage());
            
        }

        return $path;

    }

    public function download(Order $order)
    {
        $order->load('user','orderDetails.product');

        return Pdf::loadView(
            'pdf.invoice',
            compact('order')
        )->download("invoice-{$order->order_number}.pdf");
    }

    public function stream(Order $order)
    {
        $order->load('user','orderDetails.product');

        return Pdf::loadView(
            'pdf.invoice',
            compact('order')
        )->stream();
    }
    
}