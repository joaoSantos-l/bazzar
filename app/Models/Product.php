<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; 
    protected $fillable = [
        'user_id',
        'productName',
        'seller',
        'description',
        'price',
        'stock',
        'image_path',
    ];


    public static function searchByProduct($product){
        return self::where('product',$product)->get()->first();
    }

    public static function deleteUser($id){
        Usuario::destroy($id);
        
    }
}
