<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class EdicaoController extends Controller
{
    public function editShow(){
        $id = session('user.id');
        $usuario_data = Usuario:: where('id', $id)->first();
; 

        return view('edicao', compact('usuario_data')); 
    }

}
