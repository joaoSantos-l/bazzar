<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Product $product)
    {
        $userId = session('user')['id'];

        $exists = Wishlist::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            Wishlist::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->delete();
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $product->id
            ]);
        }

        return redirect()->back();
    }

}
