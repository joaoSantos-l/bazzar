<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        $id = session('user.id');
        $user_data = Usuario::findOrFail($id);

        return view('main.user.profile', compact('user_data'));
    }

    public function update(Request $request)
    {
        $userId = session('user.id');
        $user = Usuario::findOrFail($userId);

        $data = $request->validate([
            'edit_name' => ['required', 'string', 'max:255'],
            'edit_email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'edit_password' => [
                'nullable', 'string', 'min:8', 'max:16',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'confirmed',
            ],
        ]);

        $user->user = $data['edit_name'];
        $user->email = $data['edit_email'];

        if (!empty($data['edit_password'])) {
            $user->senha = Hash::make($data['edit_password']);
        }

        $user->save();

            return redirect()->route('user.show')->with('success', 'Perfil atualizado com sucesso!');
        }

    public function destroy()
    {
        $id = session('user.id');
        $user = Usuario::findOrFail($id);
        $user->delete();

        session()->forget('user');

    return redirect()->route('index')->with('deletion-success', 'Conta deletada com sucesso!');
    }
}
