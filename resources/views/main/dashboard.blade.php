@extends('layouts.main_layout')

@section('content')
    <div class="min-h-screen flex flex-col bg-gray-50">

        <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center sticky top-0 z-50">
            <div class="hidden md:flex items-center gap-2">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14">
                </a>
            </div>

            <div class="flex items-center gap-4">
                <form action="" method="GET" class="relative w-64 md:w-96">
                    <input type="text" name="q" placeholder="Buscar produtos..."
                        class="w-full rounded-full border border-gray-300 pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FF5A4B] focus:border-transparent shadow-sm"
                        value="{{ request('q') }}">
                    <i class="bi bi-search absolute left-3 top-2.5 text-gray-400"></i>
                </form>

                <a href="{{ route('product.create') }}"
                    class="hidden md:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#FF5A4B] text-white font-semibold hover:brightness-110 transition">
                    <i class="bi bi-plus-circle"></i> Adicionar Produto
                </a>

                <a href="{{ route('cart.show') }}" class="relative">
                    <i class="bi bi-cart text-2xl"></i>

                    <span class="absolute -top-2 -right-3 bg-[#FF5A4B] text-white text-xs px-2 py-1 rounded-full">
                        {{ $cartSummary->total_qty ?? 0 }}
                    </span>
                </a>

                <span class="font-semibold text-gray-700">
                    R$ {{ number_format($cartSummary->total_price ?? 0, 2, ',', '.') }}
                </span>


                <div class="hidden md:flex gap-2">
                    <button id="profileMenuButton"
                        class="flex items-center cursor-pointer gap-2 font-semibold md:p-3 rounded-lg md:text-2xl text-gray-700 hover:text-[#FF5A4B] hover:bg-gray-200 transition">
                        <i class="bi bi-person-fill"></i> Perfil
                    </button>
                </div>

                <div id="profileMenu"
                    class="p-4 absolute top-18 right-6 mt-2 bg-white rounded-lg inset-shadow-sm flex flex-col hidden">
                    <a href="{{ route('user.show') }}"
                        class="flex items-center gap-2 px-4 py-2 text-gray-700 rounded-lg hover:text-[#FF5A4B] hover:bg-gray-100 transition">
                        <i class="bi bi-person"></i> Perfil
                    </a>
                    <a href="{{ route('logout') }}"
                        class="flex items-center gap-2 px-4 py-2 text-red-500 rounded-lg hover:text-white hover:bg-red-700 transition">
                        <i class="bi bi-box-arrow-in-left"></i> Logout
                    </a>
                </div>

                <div class="md:hidden">
                    <button id="mobileMenuButton" class="text-gray-700 text-2xl focus:outline-none">
                        <i class="bi bi-list"></i>
                    </button>
                </div>

                <div id="mobileMenu"
                    class="p-4 absolute top-18 right-6 mt-2 bg-white rounded-lg inset-shadow-sm flex flex-col hidden">
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-[#FF5A4B] hover:bg-gray-100 transition">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-[#FF5A4B] hover:bg-gray-100 transition">
                        <i class="bi bi-person-plus-fill"></i> Cadastro
                    </a>
                </div>
            </div>
        </nav>

        <section class="flex-1 px-6 md:px-10 py-10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Produtos em Destaque</h2>
                <a href=""
                    class="md:hidden inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#FF5A4B] text-white font-semibold hover:brightness-110 transition">
                    <i class="bi bi-plus-circle"></i> Adicionar
                </a>
            </div>

            @if ($products->isEmpty())
                <div class="text-center text-gray-500 mt-20">
                    <i class="bi bi-bag-x text-5xl mb-4"></i>
                    <p>Nenhum produto encontrado.</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach ($products as $product)
                        <div
                            class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden border border-gray-100">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->productName }}"
                                style="width: 500px; height: 300px; object-fit: cover;">
                            <div class="p-4 flex flex-col justify-between">
                                <h3 class="font-semibold text-gray-800 mb-2 truncate">{{ $product->productName }}</h3>
                                <p class="text-[#FF5A4B] font-bold mb-3">R$
                                    {{ number_format($product->price, 2, ',', '.') }}</p>
                                <div class="flex justify-between items-center">
                                    @if (Session('user')['id'] == $product->user_id)
                                        <a href="{{ route('product.edit', $product->id) }}"II
                                            class="text-sm text-gray-600 hover:text-[#FF5A4B] transition">
                                            Editar
                                        </a>

                                        <div class="flex gap-3">
                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                                onsubmit="return confirm('Excluir este produto?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-500 hover:text-red-700 transition cursor-pointer">
                                                    <i class="bi bi-trash text-2xl"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-[#FF5A4B] hover:text-[#FF3D3B] transition text-2xl cursor-pointer">
                                            @if (in_array($product->id, $wishlistIds))
                                                <i class="bi bi-heart-fill"></i>
                                            @else
                                                <i class="bi bi-heart"></i>
                                            @endif
                                        </button>
                                    </form>

                                </div>
                                <div x-data="cartComponent({{ $product->id }}, {{ $cartItems[$product->id] ?? 0 }})" class="h-[48px] flex flex-col items-center mt-4">
                                    <button x-show="!inCart()" @click="increase"
                                        class="bg-[#FF5A4B] text-white px-3 py-2 rounded-full hover:brightness-110 cursor-pointer">
                                        <i class="bi bi-cart-plus text-xl mr-2"></i>
                                        Adicionar ao carrinho
                                    </button>

                                    <div x-show="inCart()" class="flex items-center gap-3 mt-2">

                                        <button @click="decrease"
                                            class="bg-gray-300 px-2 py-1 rounded cursor-pointer">-</button>

                                        <span x-text="qty"></span>

                                        <button @click="increase"
                                            class="bg-gray-300 px-2 py-1 rounded cursor-pointer">+</button>

                                    </div>
                                </div>


                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </section>

        <div class="text-center mb-8 pt-6 border-t border-gray-200">
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Bazzar. Todos os direitos reservados.</p>
        </div>
    </div>

    <script>
        const profileButton = document.getElementById('profileMenuButton');
        const profileMenu = document.getElementById('profileMenu');
        profileButton?.addEventListener('click', () => profileMenu.classList.toggle('hidden'));
    </script>
@endsection
