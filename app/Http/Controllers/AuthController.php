<?php

namespace App\Http\Controllers;

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
                'login_email' => [
                    'required',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                ],
                'login_password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:16',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                ],
            ],
            [
                'login_email.required' => 'O campo de email é obrigatório.',
                'login_email.regex' => 'Informe um email válido.',
                'login_password.required' => 'O campo de senha é obrigatório.',
                'login_password.min' => 'A senha deve ter no mínimo 8 caracteres.',
                'login_password.max' => 'A senha deve ter no máximo 16 caracteres.',
                'login_password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma minúscula e um número.',
            ]
        );

        $email = trim($request->input('login_email'));
        $senha = trim($request->input('login_password'));

        $usuario = Usuario::where('email', $email)->first();

        if ($usuario == null || ! Hash::check($senha, $usuario->senha)) {
            return redirect()->back()->with('login-error', 'Usuário não encontrado')->withInput();
        }

        session([
            'user' => [
                'id' => $usuario->id,
                'email' => $usuario->email,
            ],
        ]);

        return redirect()->route('index');

    }

    // Edit
    public function authEdit(Request $request)
    {
        $request->validate(
            [
                'edit_email' => [
                    'required',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                ],
                'edit_password' => [
                    'string',
                    'min:8',
                    'max:16',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                ],
            ],
            [
                'edit_email.required' => 'O campo de email é obrigatório.',
                'edit_email.regex' => 'Informe um email válido.',
                'edit_password.required' => 'O campo de senha é obrigatório.',
                'edit_password.min' => 'A senha deve ter no mínimo 8 caracteres.',
                'edit_password.max' => 'A senha deve ter no máximo 16 caracteres.',
                'edit_password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma minúscula e um número.',
                'edit_nome.required' => 'O campo do nome é obrigatório.',
            ]
        );

        $id = session('user.id');
        $usuario = Usuario::find($id);

        $usuario->email = trim($request->input('edit_email'));
        $usuario->user = trim($request->input('edit_nome'));
        $usuario->save();

        return redirect()->route('profile');

    }

    // Cadastro
    public function authCadastro(Request $request)
    {
        $request->validate(
            [
                'cadastro_name' => ['required', 'string', 'max:255'],
                'cadastro_email' => [
                    'required',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                ],
                'cadastro_password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:16',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                    'confirmed',
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

        return redirect()->route('create')->with('cadastro_data', $request->all());
    }

    public function logout()
    {
        session()->forget('user');

        return redirect()->route('login');
    }
}
