<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryService{

    public function deductStock(Order $order):void{
        try{
           
            DB::transaction(function () use ($order) {

                foreach ($order->details as $item) {

                    $product = Product::lockForUpdate()->find($item->product_id);

                    if ($product->stock < $item->quantity) {
                        throw new Exception("Insufficient stock.");
                    }

                    $product->decrement('stock', $item->quantity);
                }
            });

        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }

    }

    public function restoreStock(Order $order):void{
        try{
           
            DB::transaction(function () use ($order) {

                foreach ($order->details as $item) {

                    $product = Product::lockForUpdate()->find($item->product_id);

                    if ($product->stock < $item->quantity) {
                        throw new Exception("Insufficient stock.");
                    }

                    $product->decrement('stock', $item->quantity);
                }
            });

        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }

    }

    public function checkStock(array $items):bool{
        
        foreach ($items as $item) {

            $product = Product::find($item['product_id']);

            if ($product->stock < $item['quantity']) {
                return false;
            }
        }

        return true;
    }

    public function reserveStock(array $items):bool{
        
        foreach ($items as $item) {

            $product = Product::lockForUpdate()->find($item['product_id']);

            if ($product->stock < $item['quantity']) {
                return false;
            }

            $product->decrement('stock', $item['quantity']);
        }

        return true;
    }

    public function releaseStock(array $items):bool{
        
        foreach ($items as $item) {

            $product = Product::lockForUpdate()->find($item['product_id']);

            if ($product->stock < $item['quantity']) {
                return false;
            }

            $product->decrement('stock', $item['quantity']);
        }

        return true;
    }

}