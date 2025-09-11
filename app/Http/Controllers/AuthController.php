<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuario;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Login
    public function authLogin(Request $request)
    {
        $request->validate(
            [
                'login_username' => [
                    'required',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
                ],
                'login_password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:16',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
                ],
            ],
            [
                'login_username.required' => 'O campo de email é obrigatório.',
                'login_username.regex' => 'Informe um email válido.',
                'login_password.required' => 'O campo de senha é obrigatório.',
                'login_password.min' => 'A senha deve ter no mínimo 8 caracteres.',
                'login_password.max' => 'A senha deve ter no máximo 16 caracteres.',
                'login_password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma minúscula e um número.',
            ]
        );

        $user = trim($request->input('login_username'));
        $senha = trim($request->input('login_password'));

        $usuario = Usuario::where('email', $user)->first();

        if ($usuario == null || !Hash::check($senha, $usuario->senha)) {
            return redirect()->back()->with('login-error', 'Usuário não encontrado')->withInput();
        }

        session([
            'user' => [
                'id' => $usuario->id,
                'username' => $usuario->email
            ]
        ]);

        return redirect()->route('index');

    }

    // Cadastro
    public function authCadastro(Request $request)
    {
        $request->validate(
            [
                'cadastro_name' => ['required', 'string', 'max:255'],
                'cadastro_email' => [
                    'required',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
                ],
                'cadastro_password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:16',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                    'confirmed'
                ],
            ],
            [
                'cadastro_name.required' => 'O campo de nome é obrigatório.',
                'cadastro_name.max' => 'O nome deve ter no máximo 255 caracteres.',
                'cadastro_email.required' => 'O campo de email é obrigatório.',
                'cadastro_email.regex' => 'Informe um email válido.',
                'cadastro_password.required' => 'O campo de senha é obrigatório.',
                'cadastro_password.min' => 'A senha deve ter no mínimo 8 caracteres.',
                'cadastro_password.max' => 'A senha deve ter no máximo 16 caracteres.',
                'cadastro_password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma minúscula e um número.',
                'cadastro_password.confirmed' => 'As senhas não coincidem.',
            ]
        );
        $usuarioStr = trim($request->input('cadastro_name'));
        $email = trim($request->input('cadastro_email'));
        $senha = trim($request->input('cadastro_password'));

        $senha = Hash::make($senha);

        $usuario = new Usuario();
        $usuario->user = $usuarioStr;
        $usuario->email = $email;
        $usuario->senha = $senha;

        $usuario->save();

        return redirect()->route('index');
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }
}



