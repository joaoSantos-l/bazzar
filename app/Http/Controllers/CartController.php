<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return redirect()->back();
    }

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
        $cartSummary = $this->getCartSummary();


        return view('main.user.cart', compact('cart', 'cartSummary'));
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
        } else {
            Cart::updateOrCreate(
                [
                    'user_id' => $userId,
                    'product_id' => $request->product_id
                ],
                [
                    'quantity' => $request->quantity
                ]
            );
        }

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->with('product')
            ->first();

        $singleTotal = $cartItem ? $cartItem->quantity * $cartItem->product->price : 0;

        $cartSummary = $this->getCartSummary();

        return response()->json([
            'status' => $request->quantity <= 0 ? 'removed' : 'updated',
            'product_id' => $request->product_id,
            'quantity' => $cartItem->quantity ?? 0,
            'product_total' => number_format($singleTotal, 2, ',', '.'),
            'cart_summary' => [
                'total_qty' => $cartSummary->total_qty ?? 0,
                'total_price' => number_format($cartSummary->total_price ?? 0, 2, ',', '.')
            ]
        ]);
    }

    private function getCartSummary()
    {
        $cartItems = Cart::where('user_id', session('user')['id'])
            ->with('product')
            ->get();

        return (object) [
            'total_qty' => $cartItems->sum(fn($item) => $item->quantity),
            'total_price' => $cartItems->sum(fn($item) => $item->quantity * $item->product->price)
        ];
    }


}
