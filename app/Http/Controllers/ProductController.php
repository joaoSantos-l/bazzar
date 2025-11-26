<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Usuario;
use App\Models\Cart;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('index');
    }


    public function create()
    {
        $id = session('user.id');
        $user_data = Usuario::findOrFail($id);

        return view('main.product.create', compact('user_data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'productName' => 'required|string|max:255',
            'seller' => 'required|string|max:30',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');

        }
        $data = $validated;
        $data['user_id'] = session('user.id');
        $data['image_path'] = $imagePath;
        unset($data['image']);

        Product::create($data);

        return redirect()->route('dashboard')->with('success', 'Produto adicionado com sucesso!');
    }

    public function edit(Request $request, $id)
    {
        $previousUrl = $request->header('referer');

        $isProfile = false;
        $isDashboard = false;

        $profileUrl = URL::route('user.show');
        $dashboardUrl = URL::route('dashboard');

        if ($previousUrl && str_contains($previousUrl, $profileUrl)) {
            $isProfile = true;
        } else if ($previousUrl && str_contains($previousUrl, $dashboardUrl)) {
            $isDashboard = true;
        }

        $product = Product::findOrFail($id);
        return view('main.product.edit', compact('product', 'isProfile', 'isDashboard'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'productName' => 'required|string|max:255',
            'seller' => 'required|string|max:30',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'isProfile' => 'nullable|boolean',
            'isDashboard' => 'nullable|boolean',
        ]);

        $isProfile = $request->input('isProfile', false);
        $isDashboard = $request->input('isDashboard', false);

        $product = Product::findOrFail($id);
        $product->update($validated);

        if ($isProfile) {
            return redirect()->route('user.show')->with('success', 'Produto atualizado com sucesso!');
        } else if ($isDashboard) {
            return redirect()->route('dashboard')->with('success', 'Produto atualizado com sucesso!');
        }

        return redirect()->route('dashboard')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Produto excluído com sucesso!');
    }
}