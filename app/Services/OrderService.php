<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\OrderProduct;

class OrderService
{
    private $OrderObj;
    private $OrderProductObj;

    public function __construct(Order $OrderObj, OrderProduct $OrderProductObj)
    {
        $this->OrderObj = $OrderObj;
        $this->OrderProductObj = $OrderProductObj;
    }

    public function collection($inputs = null)
    {
        if ($inputs['limit'] == '-1') {
            //if values set for search query
            if (isset($inputs['search'])) {
                $order = $this->OrderObj->with('OrderProduct', 'user', 'OrderProduct.product')->where('orders.phone_no', 'LIKE', "%{$inputs['search']}%")->get();
            } else {
                $order = $this->OrderObj->with('OrderProduct', 'user', 'OrderProduct.product')->get();
            }
        } else {
            if (isset($inputs['search'])) {
                $order = $this->OrderObj->with('OrderProduct', 'user', 'OrderProduct.product')->where('orders.phone_no', 'LIKE', "%{$inputs['search']}%")->paginate($inputs['limit']);
            } else {
                $order = $this->OrderObj->with('OrderProduct', 'user', 'OrderProduct.product')->paginate($inputs['limit']);
            }
        }
        return $order;
    }

    public function resource($id)
    {
        $order = $this->OrderObj->with('OrderProduct', 'user','OrderProduct.product')->findOrFail($id);
        return $order;
    }

    public function store($inputs = null)
    {
        $cart = Cart::with('cartProduct')->where('user_id', Auth::id())->first();
        $totalCalculation = $this->totalCalculation($cart->cartProduct);

        $order = $this->OrderObj->create([
            'user_id' => Auth::id(),
            'amount' => $totalCalculation['amount'],
            'cgst' => $totalCalculation['cgst'],
            'sgst' => $totalCalculation['sgst'],
            'total' => $totalCalculation['total'],
            'phone_no' => $inputs['phone_no'],
            'shipping_address' => $inputs['shipping_address'],
            'billing_address' => $inputs['billing_address'],
        ]);

        foreach($cart->cartProduct as $product)
        {
            $products = Product::where('id', $product['product_id'])->first();
            $this->OrderProductObj->create([
            'order_id' => $order->id,
            'product_id' => $products->id,
            'quantity' => $product['quantity'],
            'amount' => $products->price,
            'total' => $product['quantity'] * $products->price
            ]);
        }

        $order =  $this->resource($order->id);
        return $order;
    }

    public function update($inputs, $id)
    {
        $order = $this->resource($id);
        $order->update([
            'phone_no' => $inputs['phone_no'],
            'shipping_address' => $inputs['shipping_address'],
            'billing_address' => $inputs['billing_address'],
        ]);
        return $order;
    }

    public function delete($id)
    {
        $order = $this->resource($id);
        if($order->orderProduct()->delete() == true && $order->delete() == true) {
            $data['delete']['sucess'] = __('validation.delete');
            return $data;
        }
    }

    public function totalCalculation($products)
    {
        $amount = 0;
        $cgst = 30.00;
        $sgst = 30.00;
        $total = 0;
        foreach ($products as $product) {
            $products = Product::where('id', $product['product_id'])->first();
            $amount = $products->price * $product['quantity'];
            $gst = $cgst + $sgst;
            $total +=  $amount + $gst;
        }
        return ['amount' => $amount, 'cgst' => $cgst, 'sgst' => $sgst, 'total' => $total];
    }
}

