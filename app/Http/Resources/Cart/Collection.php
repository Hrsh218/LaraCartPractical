<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Collection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\Cart\Resource';

    public function toArray($request)
    {
        return $this->collection;
    }
}
