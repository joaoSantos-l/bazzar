<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\EdicaoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeleteController;
use App\Http\Middleware\CheckLogged;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/cadastro', [CadastroController::class, 'cadastro'])->name('cadastro');

Route::get('/create', [CadastroController::class, 'create'])->name('create');

Route::post('/loginSubmit', [AuthController::class, 'authLogin'])->name('auth.login');
Route::post('/cadastroSubmit', [AuthController::class, 'authCadastro'])->name('auth.cadastro');

Route::middleware([CheckLogged::class])->group(
    function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::post('/authEdit', [AuthController::class, 'authEdit'])->name('auth.edit');
        Route::get('/delete', [DeleteController::class, 'delete'])->name('delete');
        Route::get('/profile', [ProfileController::class, 'profileShow'])->name('profile');
        Route::get('/editUser', [EdicaoController::class, 'editShow'])->name('editShow');
    }
);

Route::get('/', function () {
    return view('main_page');
})->name('index');
