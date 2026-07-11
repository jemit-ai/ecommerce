<?php

namespace App\Http\Controllers;
use App\Services\Order\OrderService;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function __construct(public OrderService $orderService) {}

    function store(Request $request){

        try{

            /*$validated = $request->validate([
                'products'         => 'required|array',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity'   => 'required|integer|min:1',
                'coupon_code'      => 'nullable|string|max:255',
                'payment_method'   => 'required|string|in:stripe,paypal,cod',
            ]);*/

            $validated = [
                'products' => [
                    [
                        'product_id' => 1,
                        'quantity'   => 2,
                    ],
                    [
                        'product_id' => 2,
                        'quantity'   => 1,
                    ],
                 ],
                'coupon_code'    => 'SAVE10',
                'payment_method' => 'cod',
            ];

            $order = $this->orderService->create($validated);

            //return redirect()->route('order.success', $order->id);

        }catch(Exception $e){
            
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    function cancel(Request $request){



    }
        
    
}
