<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Session;

class AdminController extends Controller
{
    function show()
    {
        $users = Usuario::all();

        return view("main.user.admin.users_list", compact("users"));
    }

    function sudo($id)
    {
        $user = Usuario::findOrFail($id);

        if ($id == Session('user')['id']) {
            return redirect()->back()->with('error', 'Você não pode alterar seu próprio status de admin.');
        }

        if ($user->admin) {
            $user->admin = false;
            $user->save();

            return redirect()->back()->with('success', 'O usuário não é mais admin!');
        }

        $user->admin = true;
        $user->save();

        return redirect()->back()->with('success', 'O usuário agora é admin!');
    }


}
