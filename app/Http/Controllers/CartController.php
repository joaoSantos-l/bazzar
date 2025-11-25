<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function toggle(Product $product)
    {
        $userId = session('user')['id'];

        $exists = Cart::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            Cart::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->delete();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id
            ]);
        }

        return redirect()->back();
    }

    public function show()
    {
        $id = session('user.id');
        
        $cartQuery = Cart::query();
        $cart = $cartQuery->where('user_id', $id)->with('product')->get();
        $cartIds = Cart::where('user_id', session('user')['id'])
            ->pluck('product_id')
            ->toArray();

        return view('main.user.cart', compact('cart', 'cartIds'));
    }

}
