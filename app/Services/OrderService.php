<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{

    public function create(array $data):Order{

        try{

            DB::beginTransaction();

            $order = Order::create([
                'user_id'=>$data['user_id'],
                'order_number'=>Str::random(10),
                'payment_method'=>$data['payment_method'],
                'payment_id'=>$data['payment_id'],
                'order_status'=>$data['order_status'],
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
                //$product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            return $order;

        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }

    }

}