@extends('layouts.main_layout')

@section('content')
<div class="flex-1 flex flex-col p-6 md:p-10 overflow-y-auto">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Produto</h1>

        <form action="{{ route('product.update', $product->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-semibold">Nome do Produto</label>
                <input type="text" name="productName" value="{{ old('productName', $product->productName) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#FF5A4B] focus:border-[#FF5A4B]">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Vendedor</label>
                <input type="text" name="seller" value="{{ old('seller', $product->seller) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Descrição</label>
                <textarea name="description" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold">Estoque</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold">Preço</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('dashboard') }}"
                    class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">Cancelar</a>
                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-[#FF5A4B] text-white font-semibold hover:brightness-110 transition">
                    Atualizar Produto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
