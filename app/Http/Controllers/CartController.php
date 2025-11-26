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

        $exists = Cart::where('user_id', $userId)->where('product_id', $product->id)->exists();

        if ($exists) {
            Cart::where('user_id', $userId)->where('product_id', $product->id)->delete();
        }

        Cart::create([
            'user_id' => $userId,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        return redirect()->back();
    }

    public function show()
    {
        $id = session('user.id');

        $cartQuery = Cart::query();
        $cart = $cartQuery->where('user_id', $id)->with('product')->get();
        $cartIds = Cart::where('user_id', session('user')['id'])->pluck('product_id')->toArray();

        return view('main.user.cart', compact('cart', 'cartIds'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer'
        ]);

        $userId = session('user')['id'];

        if ($request->quantity <= 0) {
            Cart::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->delete();

            return response()->json([
                'status' => 'removed',
                'product_id' => $request->product_id
            ]);
        }

        Cart::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $request->product_id
            ],
            [
                'quantity' => $request->quantity
            ]
        );

        return response()->json([
            'status' => 'updated',
            'product_id' => $request->product_id,
            'quantity' => $request->quantity
        ]);
    }


}
