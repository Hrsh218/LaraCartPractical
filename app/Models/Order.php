<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OrderProduct;
use App\Models\User;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'amount',
        'cgst',
        'sgst',
        'total',
        'phone_no',
        'shipping_address',
        'billing_address'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }
}
