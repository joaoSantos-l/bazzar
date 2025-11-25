@extends('layouts.main_layout')

@section('content')
    <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                    <i class="bi bi-heart text-[#FF5A4B] mr-2"></i>
                                    Carrinho
                                </h3>
                            </div>
                            <p class="text-gray-500 mb-4">Seus produtos no Carrinho</p>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach ($cart as $item)
                                    <div
                                        class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden border border-gray-100">
                                        <img src="{{ asset('storage/' . $item->product->image_path) }}"
                                            alt="{{ $item->product->productName }}"
                                            style="width: 200px; height: 100px; object-fit: cover;">
                                        <div class="p-4 flex flex-col justify-between">
                                            <h3 class="font-semibold text-gray-800 mb-2 truncate">
                                                {{ $item->product->productName }}</h3>
                                            <p class="text-[#FF5A4B] font-bold mb-3">R$
                                                {{ number_format($item->product->price, 2, ',', '.') }}</p>
                                            <form action="{{ route('cart.toggle', $item->product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="text-[#FF5A4B] hover:text-[#FF3D3B] transition text-2xl">
                                                    @if (in_array($item->product->id, $cartIds))
                                                        <i class="bi bi-cart-fill"></i>
                                                    @else
                                                        <i class="bi bi-cart"></i>
                                                    @endif
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
@endsection