<?php
namespace App\Services\Order;

use App\Models\Order\Order;
use App\Models\Order\OrderDetail;
use App\Models\Product;
use App\Models\Order\OrderTimeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderCancelled;
use App\Services\Order\InventoryService;
use App\Events\Order\OrderPlaced;

use Exception;

class OrderService
{

    public function __construct(public InventoryService $inventoryService){}
    
    public function create(array $data):Order{

        \Log::info("Order created...");
        //dd($data); 
        
        try{

            $order = DB::transaction(function () use ($data) {

                $coupon_code    = $data['coupon_code']; 
                $payment_method = $data['payment_method'];
                $product_id     = $data['products'][0]['product_id'];
                $quantity       = $data['products'][0]['quantity'];   

                \Log::warning('#user ID Placed  $order = Order::create([ 
                    user_id       => 3,'."File:--->".__FILE__."Line:--->".__LINE__);

                $order = Order::create([ 
                    'user_id'        => 3,
                    'order_number'   => Str::random(10),
                    'payment_method' => $payment_method,
                    'payment_id'     => 1,
                    'order_status'   => 'pending',
                ]);

                foreach ($data['products'] as $item) {

                    $product = Product::findOrFail($item['product_id']);

                    OrderDetail::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'price'      => $product->price,
                        'quantity'   => $item['quantity'],
                        'total'      => $product->price * $item['quantity'],
                    ]);

                    // Reduce Stock
                    // $product->decrement('stock', $item['quantity']);
                    //$this->inventoryService->reserveStock($product, $item['quantity']);

                }

                // $this->inventoryService->deductStock($order);

                // save payment

                // clear cart

                return $order;

            });

            // After Transaction 
            // Event(new OrderPlaced($order));

            DB::afterCommit(function () use ($order) {
                OrderPlaced::dispatch($order); 
            }); 
            
            return $order;
            
        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }

    }

    public function cancel(Order $order){

        try{

            $order = DB::transaction(function () use ($order) {

                $order->update([
                    'order_status'   => 'cancelled',
                ]);

                foreach ($order->details as $item) {

                    $product = Product::findOrFail($item['product_id']);

                    $product->increment('stock', $item['quantity']);
                }

                return $order;
            });

            
            return $order;

        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }

    }

    public function generateOrderNo(Order $order){

        \Log::info("Order number generation started");

        // $order = Order::find($order->id);
        // $order->update([
        //     'order_number' => Str::random(10),
        // ]); 

        try{

            $order = Order::find($order->id);
            $order->update([
            'order_number' => 'ORD-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
            ]); 

        }catch(Exception $e){

            \Log::info("Error in generating order number: {$e->getMessage()}"); 
            
        }
        

    }

    public function getOrderById($id){
        return Order::find($id);
    }

    /*
    public function createTimeLine(Order $order)
    { 
        try{

            OrderTimeline::create([
                'order_id'   => $order->id,
                'user_id'    => $order->user_id,
                'status'     => $order->order_status,
                'title'      => 'Order Placed',
                'description'=> 'Your order has been placed successfully.',
                'created_by' => $order->user_id,
                'event_time' => now(),
            ]);

        }catch(Exception $e){

            \Log::info("Error in creating timeline: {$e->getMessage()}"); 
            
        }    

    }
    */
}