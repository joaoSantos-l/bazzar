<?php

namespace App\Http\Controllers;
use Hash;
use App\Models\Usuario;


class CadastroController extends Controller
{
    public function cadastro()
    {
        return view('cadastro');
    }

    public function create()
    {
        $requestCadastro = session('cadastro_data');

        $usuarioStr = trim($requestCadastro['cadastro_name']);
        $email = trim($requestCadastro['cadastro_email']);
        $senha = trim($requestCadastro['cadastro_password']);

        $senha = Hash::make($senha);

        $usuario = new Usuario;
        $usuario->user = $usuarioStr;
        $usuario->email = $email;
        $usuario->senha = $senha;

        $usuario->save();

        return redirect()->route('index');
    }
}
