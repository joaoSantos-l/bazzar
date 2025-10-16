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
                            <img src="{{ $product->image_url ?? asset('images/placeholder.png') }}"
                                alt="{{ $product->productName }}" class="h-48 w-full object-cover">
                            <div class="p-4 flex flex-col justify-between">
                                <h3 class="font-semibold text-gray-800 mb-2 truncate">{{ $product->productName }}</h3>
                                <p class="text-[#FF5A4B] font-bold mb-3">R$
                                    {{ number_format($product->price, 2, ',', '.') }}</p>
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('product.edit', $product->id) }}"
                                        class="text-sm text-gray-600 hover:text-[#FF5A4B] transition">
                                        Editar
                                    </a>
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Excluir este produto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>

                                <button class="text-[#FF5A4B] hover:text-[#FF3D3B] transition">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </section>

        <footer class="bg-white mt-auto py-6 text-center text-gray-400 border-t">
            &copy; {{ date('Y') }} Bazzar. Todos os direitos reservados.
        </footer>
    </div>

    <script>
        const profileButton = document.getElementById('profileMenuButton');
        const profileMenu = document.getElementById('profileMenu');
        profileButton?.addEventListener('click', () => profileMenu.classList.toggle('hidden'));
    </script>
@endsection
