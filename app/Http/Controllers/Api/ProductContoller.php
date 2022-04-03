<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Http\Requests\Product\Create;
use App\Http\Requests\Product\Update;
use App\Http\Resources\Product\Resource as ProductResource;
use App\Http\Resources\Product\Collection as ProductCollection;

class ProductContoller extends Controller
{
    use ApiResponser;
    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $data = $this->service->collection($request->all());
        return $this->collection(new ProductCollection($data));
    }

    public function store(Create $request)
    {
       $data = $this->service->store($request);
       return $this->resource(new ProductResource($data));
    }

    public function show($id)
    {
        $data = $this->service->resource($id);
        return $this->resource(new ProductResource($data));
    }

    public function update(Update $request, $id)
    {
        $data = $this->service->update($request);
        return $this->resource(new ProductResource($data));
    }

    public function destroy($id)
    {
        $data = $this->service->delete($id);
        return $data;
    }
}
