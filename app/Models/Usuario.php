<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'user';

    public static function searchByUser($user){
        return self::where('user',$user)->get()->first();
    }

    public static function deleteUser($id){
        Usuario::destroy($id);
        
    }
    
}