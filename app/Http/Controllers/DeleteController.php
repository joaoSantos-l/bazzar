<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class DeleteController extends Controller
{
    function delete(){

        $user = new Usuario();
        
        $id=session('user.id');
        
        $user->deleteUser($id);
        
        return redirect()->route('logout');
    }
}
