<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('index');
    }
}
