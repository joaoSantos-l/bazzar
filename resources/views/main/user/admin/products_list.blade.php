@extends('layouts.main_layout')

@section('content')
    <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center sticky top-0 z-50">
        <div class="hidden md:flex items-center gap-2">
            <a href="{{ route('index') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14">
            </a>
        </div>

        <div class="flex items-center gap-4">
            <div x-data="{ totalQty: {{ $cartSummary->total_qty ?? 0 }}, totalPrice: '{{ number_format($cartSummary->total_price ?? 0, 2, ',', '.') }}' }"
                @cart-updated.window="totalQty = $event.detail.total_qty; totalPrice = $event.detail.total_price"
                class="flex items-center gap-4">
                <a href="{{ route('cart.show') }}" class="relative">
                    <i class="bi bi-cart text-2xl"></i>

                    <span class="absolute -top-2 -right-3 bg-[#FF5A4B] text-white text-xs px-2 py-1 rounded-full"
                        x-text="totalQty">
                    </span>
                </a>

                <span class="font-semibold text-gray-700">
                    R$ <span x-text="totalPrice"></span>
                </span>
            </div>

            <div class="hidden md:flex gap-2">
                <a href="{{ route('admin.users') }}"
                    class="flex items-center cursor-pointer gap-2 font-semibold md:p-3 rounded-lg md:text-2xl text-gray-700 hover:text-[#FF5A4B] hover:bg-gray-200 transition">
                    <i class="bi bi-people-fill"></i> Usuários
                </a>
            </div>

            <div class="hidden md:flex gap-2">
                <a href="{{ route('admin.products') }}"
                    class="flex items-center cursor-pointer gap-2 font-semibold md:p-3 rounded-lg md:text-2xl text-[#FF5A4B] hover:text-[#FF5A4B] hover:bg-gray-200 transition">
                    <i class="bi bi-bag-fill"></i> Produtos
                </a>
            </div>

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

    <div class="min-h-screen flex flex-col bg-gray-50">

        <section class="flex-1 px-6 md:px-10 py-10">
            <div class="max-w-7xl mx-auto">

                <div class="flex justify-between items-center mb-6">
                    <div class="flex gap-4">
                        <h1 class="text-3xl font-bold text-gray-800">Gerenciamento de Produtos</h1>
                        @if ($query)
                            <a href="{{ route('admin.products') }}"
                                class="bg-gray-300 text-lg hover:bg-gray-400 p-2 rounded-2xl" title="Limpar pesquisa">
                                {{ $query }}
                                <i class="bi bi-x-circle"></i>
                            </a>
                        @endif
                    </div>
                    <div class="flex gap-6">
                        <form x-data="searchComponent()" action="{{ route('admin.products') }}" method="GET"
                            class="relative w-64 md:w-96 flex items-center">
                            <div class="relative flex-grow">
                                <input type="text" x-model="query" name="q"" placeholder="Buscar produtos..."
                                    class="w-full rounded-full border border-gray-300 pl-10 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#FF5A4B] focus:border-transparent shadow-sm">

                                <i class="bi bi-search absolute left-3 top-2.5 text-gray-400"></i>

                                <div x-show="isLoading" class="absolute right-10 top-2.5">
                                    <i class="bi bi-arrow-repeat animate-spin text-gray-400 text-sm"></i>
                                </div>

                                <button x-show="query && !isLoading" @click="clearSearch()" type="button"
                                    class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                    <i class="bi bi-x-circle"></i>
                                </button>

                                <div x-show="isVisible && !isLoading" x-cloak
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="absolute top-full left-0 right-0 bg-white mt-2 rounded-lg shadow-lg z-50 max-w-100 max-h-96 overflow-y-auto border border-gray-200">


                                    <div x-show="!results && query" class="p-4 text-gray-500 text-center">
                                        Digite para buscar produtos...
                                    </div>
                                </div>
                            </div>

                            <button x-show="query && !isLoading" @click="clearSearch()" type="button"
                                class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                <i class="bi bi-x-circle"></i>
                            </button>

                            <button type="submit"
                                class="ml-2 px-4 py-2 rounded-full bg-[#FF5A4B] text-white font-semibold hover:brightness-110 transition shrink-0">
                                Buscar
                            </button>
                        </form>
                        <a href="{{ route('product.create') }}"
                            class="px-4 py-2 bg-[#FF5A4B] text-white font-semibold rounded-lg shadow hover:brightness-110 transition">
                            <i class="bi bi-plus-lg mr-2"></i> Novo Produto
                        </a>
                    </div>

                </div>

                <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Lista de Produtos</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>

                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Imagem
                                    </th>

                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nome
                                    </th>

                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Vendedor
                                    </th>

                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Preço
                                    </th>

                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estoque
                                    </th>

                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $product->id }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <img class="rounded-lg"
                                                src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('images/no-image.png') }}"
                                                alt="Imagem" style="width: 100px; height: auto; object-fit: cover;">
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->productName }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->seller }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            R$ {{ number_format($product->price, 2, ',', '.') }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->stock }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="text-[#FF5A4B] p-2" title="Editar">
                                                    <i class="bi bi-pencil text-lg"></i>
                                                </a>

                                                <form action="{{ route('product.destroy', $product->id) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('Tem certeza que deseja deletar o produto {{ $product->productName }}?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 p-2 transition cursor-pointer"
                                                        title="Deletar">
                                                        <i class="bi bi-trash text-lg"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>

                @include('components.footer')

            </div>

            <script>
                const profileButton = document.getElementById('profileMenuButton');
                const profileMenu = document.getElementById('profileMenu');
                profileButton?.addEventListener('click', () => profileMenu.classList.toggle('hidden'));
            </script>
        @endsection
