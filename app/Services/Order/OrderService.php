<?php
namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use App\Events\Order\OrderPlaced;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderCancelled;
use App\Services\Order\InventoryService;



use Exception;

class OrderService
{

    public function __construct(public InventoryService $inventoryService){}
    
    public function create(array $data):Order{

        \Log::info("Order created...");
        
        /*try{

            $order = DB::transaction(function () use ($data) {

                $order = Order::create([ 
                    'user_id'        => 3,
                    'order_number'   => Str::random(10),
                    'payment_method' => $data['payment_method'],
                    'payment_id'     => 1,
                    'order_status'   => $data['order_status'],
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
        }*/

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
 
}