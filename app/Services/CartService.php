<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CartService
{
    private $CartObj;

    public function __construct(Cart $CartObj)
    {
        $this->CartObj = $CartObj;
    }

    public function addToCart($inputs = [])
    {
        $cart = $this->CartObj->where('user_id', Auth::id())->first();

        //check if cart is empty or not
        if (empty($cart) && $cart == null) {
            $cart = $this->CartObj->create([
                'user_id' => Auth::id(),
            ]);
        }

        foreach ($inputs['product'] as $product) {
            $products = Product::where('id', $product['id'])->first();
            if ($products == null && empty($products)) {
                $data['error']['product'] = __('validation.productnotfound');
                return $data;
            } else {

                //cart product update when the product already exist
                $cartProduct = $cart->cartProduct()->Where('product_id', $product['id'])->first();
                if (!empty($cartProduct) && $cartProduct != null) {
                    $cartProduct->cart_id = $cart->id;
                    $cartProduct->product_id = $product['id'];
                    $cartProduct->quantity  = $cartProduct->quantity + $product['quantity'];
                    $cartProduct->save();
                } else {

                    //create first time cart product
                    $cartProduct =  $cart->cartProduct()->create([
                        'cart_id' => $cart->id,
                        'product_id' => $product['id'],
                        'quantity' => $product['quantity'],
                    ]);
                }
            }
        }
        return $cart->with('user', 'cartProduct', 'cartProduct.product')->where('user_id', Auth::id())->first();
    }

    public function updateCartProduct($inputs = [])
    {
        $cart = $this->CartObj->where('user_id', Auth::id())->first();

        if ($cart == null) {
            $data['cart'] = __('validation.cartisempty');
            return $data;
        }

        $cartProduct = $cart->cartProduct->where('product_id', $inputs['product']['id'])->first();
        if (empty($cartProduct) && $cartProduct == null) {
            $data['error']['product'] = __('validation.productnotfound');
            return $data;
        }
        if ($cartProduct->quantity  == 0 || $inputs['product']['quantity'] == 0) {
            $cartProduct->delete();
        } else {
            $cartProduct->quantity = $cartProduct->quantity + $inputs['product']['quantity'];
            $cartProduct->save();
        }
        return $cart->with('user', 'cartProduct', 'cartProduct.product')->where('user_id', Auth::id())->first();
    }
}
