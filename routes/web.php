<?php

use App\Http\Controllers\CadastroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/cadastro', [CadastroController::class, 'cadastro'])->name('cadastro');

Route::post('/loginSubmit', [AuthController::class, 'authLogin'])->name('auth.login');
Route::post('/cadastroSubmit', [AuthController::class, 'authCadastro'])->name('auth.cadastro');

Route::get('/', function () {
    return view('main_page'); // ou qualquer blade que seja a página inicial
})->name('index');
