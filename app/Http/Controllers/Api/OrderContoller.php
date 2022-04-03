<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Order\Resource as OrderResource;
use App\Services\OrderService;
use App\Traits\ApiResponser;
use App\Http\Resources\Order\Collection as OrderCollection;

class OrderContoller extends Controller
{
    use ApiResponser;
    Private $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $data = $this->service->collection($request->all());
        return $this->collection(new OrderCollection($data));
    }
    public function show($id)
    {
        $data = $this->service->resource($id);
        return $this->resource(new OrderResource($data));
    }

    public function store(Request $request)
    {
        $data = $this->service->store($request->all());
        return $this->resource(new OrderResource($data));
    }

    public function update(Request $request, $id)
    {
        $data = $this->service->update($request->all(), $id);
        return $this->resource(new OrderResource($data));
    }

    public function destroy($id)
    {
        $data = $this->service->delete($id);
        return $this->resource(new OrderResource($data));
    }
}
