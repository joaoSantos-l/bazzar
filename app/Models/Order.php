<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    protected $fillable = [
        'user_id',
        'product_id',
        'total_price',
        'cep',
        'street',
        'number',
        'complement',
        'city',
        'state',
        'status',
        'shipping_cost'
    ];

    public function user()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
