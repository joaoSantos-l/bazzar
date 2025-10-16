<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product'; 
    protected $fillable = [
        'user_id',
        'productName',
        'seller',
        'description',
        'price',
        'stock',
    ];


    public static function searchByProduct($product){
        return self::where('product',$product)->get()->first();
    }

    public static function deleteUser($id){
        Usuario::destroy($id);
        
    }
}
