@extends('layouts.main_layout')

@section('content')
    @include('components.navbar', ['cartSummary' => $cartSummary])

    <div class="container mx-auto px-4 py-8 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Seu Carrinho de Compras</h1>

        @if ($cart->isEmpty())
            <div class="text-center py-20">
                <i class="bi bi-cart-x text-9xl text-gray-300"></i>
                <p class="text-xl text-gray-600 mt-4">Seu carrinho está vazio.</p>
                <a href="{{ route('index') }}"
                    class="mt-6 inline-block px-6 py-3 bg-[#FF5A4B] text-white font-semibold rounded-lg shadow hover:brightness-110 transition">
                    Continuar Comprando
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="lg:w-3/4">
                    <div class="bg-white shadow-md rounded-lg p-6 space-y-4">
                        @foreach ($cart as $cartItem)
                            <div class="flex items-center border-b pb-4">
                                <img class="rounded-lg mr-4"
                                    src="{{ $cartItem->product->image_path ? asset('storage/' . $cartItem->product->image_path) : asset('images/no-image.png') }}"
                                    alt="Imagem" style="width: 100px; height: auto; object-fit: cover;">
                                <div x-data="{ productId: {{ $cartItem->product_id }}, productTotal: '{{ number_format($cartItem->quantity * $cartItem->product->price ?? 0, 2, ',', '.') }}' }"
                                    @cart-updated.window="if ($event.detail.product_id === productId) productTotal = $event.detail.product_total;"
                                    class="flex-1 items-center gap-4">
                                    <h2 class="text-lg font-semibold text-gray-800">{{ $cartItem->product->productName }}
                                    </h2>
                                    <p class="text-gray-600">
                                        R$ <span x-text="productTotal"></span>
                                    </p>
                                </div>
                                <div x-data="cartComponent({{ $cartItem->product_id }}, {{ $cartItem->quantity }})">
                                    <input type="number" x-model.number="qty" @input="update(qty)" min="1"
                                        class="w-16 text-center border border-gray-300 rounded-lg py-1">
                                </div>

                                <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Excluir este produto do carrinho?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 p-2 transition cursor-pointer"
                                        title="Deletar">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="lg:w-1/4">
                    <div class="bg-white shadow-md rounded-lg p-6 sticky top-4">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Resumo do Pedido</h2>
                        <div class="space-y-2 text-gray-700">
                            <div x-data="{ subtotal: '{{ number_format($cartSummary->total_price ?? 0, 2, ',', '.') }}' }" class="flex justify-between"
                                @cart-updated.window="subtotal = event.detail.total_price">
                                <span>Subtotal:</span>
                                <span x-text="subtotal"></span>
                            </div>
                            <div class="flex justify-between font-bold text-lg pt-2 mt-2">
                                <div x-data="{ total: '{{ number_format($cartSummary->total_price ?? 0, 2, ',', '.') }}' }" class="flex justify-between"
                                    @cart-updated.window="total = event.detail.total_price">
                                    <span>Total: R$ </span>
                                    <span x-text="total"></span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('checkout') }}"
                            class="mt-6 w-full block text-center px-6 py-3 bg-[#FF5A4B] text-white font-semibold rounded-lg shadow hover:brightness-110 transition">
                            Finalizar Compra
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @include('components.footer')
@endsection
