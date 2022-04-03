<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Order;

class OrderProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'amount',
        'mrp',
        'total',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Order()
    {
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
