<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ImageUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\CheckLogged;
use App\Models\Product;
use App\Models\Wishlist;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (sem login)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/cadastro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/cadastro', [AuthController::class, 'register'])->name('auth.register');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (usuário logado)
|--------------------------------------------------------------------------
*/
Route::middleware([CheckLogged::class])->group(function () {
    // Autenticação
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Usuário
    Route::get('/profile', [UserController::class, 'show'])->name('user.show');
    Route::put('/profile', [UserController::class, 'update'])->name('user.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('user.destroy');

    // Produtos
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');
    Route::get('/produto/novo', [ProductController::class, 'create'])->name('product.create');
    Route::post('/produto', [ProductController::class, 'store'])->name('product.store');
    Route::get('/produto/{id}/editar', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/produto/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/produto/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    // Wishlist
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    //Cart
    Route::get(uri:'/cart',action:[CartController::class,'show'])->name(name:'cart.show');
    Route::post(uri:'/cart/toggle/{product}', action:[CartController::class, 'toggle'])->name(name:'Cart.toggle');
});

/*
|--------------------------------------------------------------------------
| Página inicial (Dashboard)
|--------------------------------------------------------------------------
*/
Route::get('/', function (Request $request) {
    if (session()->missing('user')) {
        return view('main.main_page');
    }

    $products = Product::orderBy('id', 'desc')->get();
    $wishlistIds = Wishlist::where('user_id', session('user')['id'])
        ->pluck('product_id')
        ->toArray();

    return view('main.dashboard', compact('products', 'wishlistIds'));
})->name('index');

