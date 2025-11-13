<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Usuario;

class ProductController extends Controller
{
public function index(Request $request)
{
    $query = Product::query();

    $products = $query->orderBy('id', 'desc')->get();

    return view('main.dashboard', compact('products'));
}


    public function create()
    {
        $id = session('user.id');
        $user_data = Usuario::findOrFail($id);
        
        return view('main.product.create', compact('user_data'));
    }
    
    public function store(Request $request)
    {

        echo (request()->null);
        $validated = $request->validate([
            'productName' => 'required|string|max:255',
            'seller' => 'required|string|max:30',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);


    //$imageName = time().'.'.request()->image->getClientOriginalExtension();
    request()->image->move(public_path('images'), 'oi');

        $validated['user_id'] = session('user.id');
        Product::create($validated);

        return redirect()->route('dashboard')->with('success', 'Produto adicionado com sucesso!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('main.product.edit', compact('products'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'productName' => 'required|string|max:255',
            'seller' => 'required|string|max:30',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()->route('dashboard')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Produto excluído com sucesso!');
    }
}
