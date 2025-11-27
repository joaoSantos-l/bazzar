<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Usuario;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('index');
    }

    public function create(Request $request)
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
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null;

        $data = $validated;
        $data['user_id'] = session('user.id');
        $data['image_path'] = $imagePath;
        unset($data['image']);

        Product::create($data);

        return $this->redirectBasedOnRoute($request);
    }

    public function edit(Request $request, $id)
    {

        $product = Product::findOrFail($id);
        return view('main.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'productName' => 'required|string|max:255',
            'seller' => 'required|string|max:30',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return $this->redirectBasedOnRoute($request);
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return $this->redirectBasedOnRoute($request);
    }

    private function redirectBasedOnRoute(Request $request, $message = 'Produto processado com sucesso!')
    {
        if ($request->has('return_to_url') && filter_var($request->input('return_to_url'), FILTER_VALIDATE_URL)) {
            $returnTo = $request->input('return_to_url');
        } else {
            $previous = $request->header('referer');

            if (str_contains($previous, URL::route('user.show'))) {
                $returnTo = URL::route('user.show');
            } elseif (str_contains($previous, URL::route('admin.products'))) {
                $returnTo = URL::route('admin.products');
            } else {
                $returnTo = URL::route('dashboard');
            }
        }

        return redirect($returnTo)->with('success', $message);
    }
}
