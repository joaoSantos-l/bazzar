<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Middleware\CheckAdmin;
use App\Models\Cart;
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
| Sem login
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/cadastro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/cadastro', [AuthController::class, 'register'])->name('auth.register');


/*
|--------------------------------------------------------------------------
| Somente logado
|--------------------------------------------------------------------------
*/
Route::middleware([CheckLogged::class])->group(function () {

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // User
    Route::get('/profile', [UserController::class, 'show'])->name('user.show');
    Route::put('/profile', [UserController::class, 'update'])->name('user.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('user.destroy');


    // Admin
    Route::middleware([CheckAdmin::class])->group(function () {
        Route::get('/admin/users', [AdminController::class, 'show'])->name('admin.users');
        Route::post('/admin/users/sudo/{id}', [AdminController::class, 'sudo'])->name('admin.users.sudo');
    });


    // Product
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');
    Route::get('/produto/novo', [ProductController::class, 'create'])->name('product.create');
    Route::post('/produto', [ProductController::class, 'store'])->name('product.store');
    Route::get('/produto/{id}/editar', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/produto/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/produto/{id}', [ProductController::class, 'destroy'])->name('product.destroy');


    // Wishlist
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');


    // Cart
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/toggle/{product}', [CartController::class, 'toggle'])->name('cart.toggle');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
});


// Main page
Route::get('/', function (Request $request) {

    if (session()->missing('user')) {
        return view('main.main_page');
    }

    $products = Product::orderBy('id', 'desc')->get();

    $wishlistIds = Wishlist::where('user_id', session('user')['id'])
        ->pluck('product_id')
        ->toArray();

    $cartItems = Cart::where('user_id', session('user')['id'])
        ->pluck('quantity', 'product_id')
        ->toArray();

    $cartSummary = Cart::where('cart.user_id', session('user')['id'])
        ->join('products', 'cart.product_id', '=', 'products.id')
        ->selectRaw('SUM(cart.quantity) as total_qty, SUM(cart.quantity * products.price) as total_price')
        ->first();

    return view('main.dashboard', compact('products', 'wishlistIds', 'cartItems', 'cartSummary'));
})->name('index');
