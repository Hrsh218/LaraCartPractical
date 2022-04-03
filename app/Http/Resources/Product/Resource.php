<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'status' => $this->status,
            'image' => asset('storage/images/' .$this->image)
        ];
        return $data;
    }
}
