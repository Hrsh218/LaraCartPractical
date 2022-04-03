<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Traits\ApiResponser;
use App\Http\Resources\Cart\Resource as CartResource;

class CartContoller extends Controller
{
    use ApiResponser;
    private $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    public function addToCart(Request $request)
    {
        $data = $this->service->addToCart($request->all());
        return $this->resource(new CartResource($data));
    }

    public function updatecartproduct(Request $request)
    {
        $data = $this->service->updatecartproduct($request->all());
        return $this->resource(new CartResource($data));
    }
}
