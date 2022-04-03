<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    private $object;

    public function __construct(Product $object)
    {
        $this->object = $object;
    }

    public function collection($inputs = null)
    {
        if ($inputs['limit'] == '-1') {
            //if values set for search query
            if (isset($inputs['search'])) {
                $products = $this->object->where('name', 'LIKE', "%{$inputs['search']}%")->get();
            } else {
                $products = $this->object->get();
            }
        } else {
            if (isset($inputs['search'])) {
                $products = $this->object->where('name', 'LIKE', "%{$inputs['search']}%")->paginate($inputs['limit']);
            } else {
                $products = $this->object->paginate($inputs['limit']);
            }
        }
        return $products;
    }

    public function store($inputs)
    {
        $product = $this->object->create([
            'name' => $inputs->name,
            'quantity' => $inputs->quantity,
            'price' => $inputs->price,
            'status' => $inputs->status,
        ]);

        if ($inputs->hasFile('image')) {
            $inputs->image->move(storage_path('app/public/images'), time() . $inputs->image->getClientOriginalName());
            $product->image = time() . $inputs->image->getClientOriginalName();
            $product->save();
        }

        return $product;
    }

    public function resource($id)
    {
        $product = $this->object->findOrFail($id);
        return $product;
    }

    public function update($inputs)
    {
        $product = $this->resource($inputs->id);

        $product->update([
            'name' => $inputs->name,
            'quantity' => $inputs->quantity,
            'price' => $inputs->price,
            'status' => $inputs->status,
        ]);

        if ($inputs->hasFile('image')) {
            $image_path = storage_path('app/public/images/') . $product->image ;
            unlink($image_path);
            $inputs->image->move(storage_path('app/public/images'), time() . $inputs->image->getClientOriginalName());
            $product->image = time() . $inputs->image->getClientOriginalName();
            $product->save();
        }
        return $product;
    }

    public function delete($id)
    {
        $product = $this->resource($id);
        if (isset($product->image)) {
            $image_path = storage_path('app/public/images/') . $product->image ;
            unlink($image_path);
        }
        if($product->delete() == true) {
            $data['delete']['sucess'] = __('validation.delete');

            return $data;
        }
    }
}
