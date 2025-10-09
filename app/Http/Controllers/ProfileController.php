<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    function profileShow(){
    
        $id = session('user.id');
        $usuario_data = Usuario:: where('id', $id)->first();
; 

        return view('profile', compact('usuario_data')); 
    }
}
