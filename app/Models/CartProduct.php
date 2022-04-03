<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Cart;
use App\Models\Product;

class CartProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cart_id',
        'product_id',
        'quantity',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class,'id', 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'id'
        );
    }
}
