<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

Class ReportService
{
    public function MinSellingProduct()
    {
        //minumum selling product
        $salesProduct = DB::table('order_products')
        ->leftJoin('products','products.id','=','order_products.product_id')
        ->select('products.*','product_id', DB::raw('count(*) as total'))
        ->groupBy('order_products.product_id')
        ->orderBy('total','desc')
        ->take(10)
        ->get();

        return $salesProduct;
    }
}
