<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\OrderController;
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
        Route::get('/admin/users', [AdminController::class, 'showUsers'])->name('admin.users');
        Route::post('/admin/users/sudo/{id}', [AdminController::class, 'sudo'])->name('admin.users.sudo');
        // Nova rota para a lista de produtos do admin (POC)
        Route::get('/admin/products', [AdminController::class, 'showProducts'])->name('admin.products');
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
    Route::delete('/cart/destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get(
        '/checkout',
        [OrderController::class, 'show']
    )->name('checkout');
    Route::post('/checkout/finalizar', [OrderController::class,'store'])->name('order.store');
});

Route::get('/', function (Request $request) {
    $query = $request->input(key: 'q');

    Log::info('Route accessed', [
        'query' => $query,
        'ajax' => $request->get('ajax'),
        'has_user' => session()->has('user')
    ]);

    if ($request->get('ajax')) {
        try {
            $productsQuery = Product::query();

            if ($query) {
                $productsQuery->where(function ($q) use ($query) {
                    $q->where('productName', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->orWhere('seller', 'like', "%{$query}%");
                });
            }

            $products = $productsQuery->get();

            Log::info('AJAX search results', [
                'query' => $query,
                'products_count' => $products->count(),
            ]);

            if ($products->isEmpty()) {
                return response('<div class="p-4 text-gray-500 text-center">Nenhum produto encontrado para "' . e($query) . '   "</div>');
            }

            return view('main.partials.search_results', compact('products'));

        } catch (Exception $e) {
            Log::error('Search error: ' . $e->getMessage());
            return response('<div class="p-4 text-gray-500 text-center">Erro interno na busca</div>', 500);
        }
    }

    $productsQuery = Product::query();

    if ($query) {
        $productsQuery->where(function ($q) use ($query) {
            $q->where('productName', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orWhere('seller', 'like', "%{$query}%");
        });
    }

    $products = $productsQuery->orderBy('id', 'desc')->get();

    if (session()->missing('user')) {
        return view('main.main_page');
    }

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

    return view('main.dashboard', compact('products', 'wishlistIds', 'cartItems', 'cartSummary', 'query'));
})->name('index');