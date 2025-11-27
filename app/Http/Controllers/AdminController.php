<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Usuario;
use Illuminate\Http\Request;
class AdminController extends Controller
{
    function showUsers()
    {
        $users = Usuario::all();
        $cartSummary = Cart::where('cart.user_id', session('user')['id'])
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->selectRaw('SUM(cart.quantity) as total_qty, SUM(cart.quantity * products.price) as total_price')
            ->first();


        return view("main.user.admin.users_list", compact("users", "cartSummary"));
    }

    function showProducts(Request $request)
    {
        $query = $request->input(key: 'q');
        $productsQuery = Product::query();

        if ($query) {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('productName', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('seller', 'like', "%{$query}%");
            });
        }

        $products = $productsQuery->orderBy('id', 'desc')->get();

        $cartSummary = Cart::where('cart.user_id', session('user')['id'])
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->selectRaw('SUM(cart.quantity) as total_qty, SUM(cart.quantity * products.price) as total_price')
            ->first();


        return view("main.user.admin.products_list", compact("products", "cartSummary", "query"));
    }

    function sudo($id)
    {
        $user = Usuario::findOrFail($id);

        if ($id == Session('user')['id']) {
            return redirect()->back()->with('error', 'Você não pode alterar seu próprio status de admin.');
        }

        if ($user->admin) {
            $user->admin = false;
            $user->save();

            return redirect()->back()->with('success', 'O usuário não é mais admin!');
        }

        $user->admin = true;
        $user->save();

        return redirect()->back()->with('success', 'O usuário agora é admin!');
    }


}
