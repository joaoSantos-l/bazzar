<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login_email' => ['required', 'email'],
            'login_password' => [
                'required', 'string', 'min:8', 'max:16',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
        ]);

        $usuario = Usuario::where('email', $credentials['login_email'])->first();

        if (! $usuario || ! Hash::check($credentials['login_password'], $usuario->senha)) {
            return back()->with('login-error', 'Credenciais inválidas')->withInput();
        }

        session([
            'user' => [
                'id' => $usuario->id,
                'email' => $usuario->email,
            ],
        ]);

        return redirect()->route('index');
    }

    /**
     * Exibe o formulário de cadastro.
     */
    public function showRegister()
    {
        return view('cadastro');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'cadastro_name' => ['required', 'string', 'max:255'],
            'cadastro_email' => ['required', 'email', 'unique:users,email'],
            'cadastro_password' => [
                'required', 'string', 'min:8', 'max:16',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'confirmed',
            ],
        ]);

        Usuario::create([
            'user' => trim($data['cadastro_name']),
            'email' => trim($data['cadastro_email']),
            'senha' => Hash::make($data['cadastro_password']),
        ]);

        $usuario = Usuario::where('email', $data['cadastro_email'])->first();

        session([
            'user' => [
                'id' => $usuario->id,
                'email' => $usuario->email,
            ],
        ]);

        return redirect()->route('index')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }
}
