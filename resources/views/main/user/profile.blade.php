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

            @if ($user_data->admin)
                <div class="hidden md:flex gap-2">
                    <a href="{{ route('admin.users') }}"
                        class="flex items-center cursor-pointer gap-2 font-semibold md:p-3 rounded-lg md:text-2xl text-gray-700 hover:text-[#FF5A4B] hover:bg-gray-200 transition">
                        <i class="bi bi-people-fill"></i> Usuários
                    </a>
                </div>

                <div class="hidden md:flex gap-2">
                    <a href="{{ route('admin.products') }}"
                        class="flex items-center cursor-pointer gap-2 font-semibold md:p-3 rounded-lg md:text-2xl text-gray-700 hover:text-[#FF5A4B] hover:bg-gray-200 transition">
                        <i class="bi bi-bag-fill"></i> Produtos
                    </a>
                </div>
            @endif

            <div class="hidden md:flex gap-2">
                <button id="profileMenuButton"
                    class="flex items-center cursor-pointer gap-2 font-semibold md:p-3 rounded-lg md:text-2xl text-[#FF5A4B] hover:text-[#FF5A4B] hover:bg-gray-200 transition">
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

    <div x-data="notif()" x-init="@if (session('success')) showSuccessNotification() @endif
    @if (session('deletion-success')) showDeletionSuccessNotification() @endif">
        <div x-data="editModal()" x-init="@if ($errors->any() || session('edit-error')) open() @endif" class="flex-1 flex flex-col p-6 md:p-10 overflow-y-auto">

            <div class="w-full max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Seu Perfil</h1>
                    <p class="text-gray-500 mt-2">Gerencie sua conta e atividades</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-gray-100">
                            <div class="flex flex-col items-center mb-6">
                                <div
                                    class="w-20 h-20 bg-gradient-to-br from-[#FF7A66] to-[#FF3D3B] rounded-full flex items-center justify-center text-white font-bold text-2xl mb-4">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-800 text-center">{{ $user_data->user }}

                                    @if ($user_data->admin)
                                        (
                                        <i class="bi bi-shield-lock text-[#FF5A4B] font-normal"> Admin</i>
                                        )
                                    @endif
                                </h2>
                                <p class="text-gray-500 text-sm mt-1">Membro desde {{ $user_data->created_at->year }}</p>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <i class="bi bi-person text-[#FF5A4B] text-lg mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Nome de usuário</p>
                                        <p class="font-medium">{{ $user_data->user }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <i class="bi bi-envelope text-[#FF5A4B] text-lg mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="font-medium">{{ $user_data->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 mt-6">
                                <button @click="open()"
                                    class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl font-medium hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                                    <i class="bi bi-pencil-square"></i>
                                    Editar Perfil
                                </button>
                                <form action="{{ route('user.destroy') }}" method="POST" x-data="deleteConfirm()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" @click="trigger($event)"
                                        class="flex items-center justify-center gap-2 px-4 py-3 
                                            bg-gradient-to-r from-red-500 to-red-600 text-white 
                                            rounded-xl font-medium hover:from-red-600 hover:to-red-700 
                                            transition-all shadow-md hover:shadow-lg w-full">
                                        <i class="bi bi-trash3"></i>
                                        <span x-text="confirm ? 'Você tem certeza?' : 'Deletar Conta'"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-gray-100 overflow-x-auto">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                    <i class="bi bi-heart text-[#FF5A4B] mr-2"></i>
                                    Lista de Desejos
                                </h3>
                            </div>
                            <p class="text-gray-500 mb-4">Seus produtos favoritos</p>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach ($wishlist as $item)
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
                                            <form action="{{ route('wishlist.toggle', $item->product->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="text-[#FF5A4B] hover:text-[#FF3D3B] transition text-2xl">
                                                    @if (in_array($item->product->id, $wishlistIds))
                                                        <i class="bi bi-heart-fill"></i>
                                                    @else
                                                        <i class="bi bi-heart"></i>
                                                    @endif
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-gray-100">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                    <i class="bi bi-box-seam text-[#FF5A4B] mr-2"></i>
                                    Meus Pedidos
                                </h3>
                            </div>
                            <p class="text-gray-500 mb-4">Seus pedidos recentes</p>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach ($orders as $order)
                                    <div
                                        class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden border border-gray-100">
                                        <div class="p-4 flex flex-col justify-between">
                                            <h3 class="font-semibold text-gray-800 mb-2 truncate">Pedido
                                                {{ $order->id }}</h3>
                                            <p class="text-[#FF5A4B] font-bold">
                                                R$ {{ number_format($order->total_price, 2, ',', '.') }}</p>
                                            </p>
                                            <p class="text-gray-600 text-sm">
                                                {{ $order->street }}, {{ $order->number }} - {{ $order->cep }}
                                            </p>
                                            <p class="text-gray-500 text-[12px]">
                                                {{ $order->city }}
                                            </p>
                                            <p class="text-gray-500 text-[12px]">
                                                {{ $order->state }}
                                            </p>


                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 overflow-x-auto">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                    <i class="bi bi-grid-3x3-gap text-[#FF5A4B] mr-2"></i>
                                    Meus Produtos
                                </h3>
                            </div>
                            <p class="text-gray-500 mb-4">Produtos que você está vendendo</p>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach ($user_products as $product)
                                    <div
                                        class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden border border-gray-100">
                                        <img src="{{ asset('storage/' . $product->image_path) }}"
                                            alt="{{ $product->productName }}"
                                            style="width: 200px; height: 100px; object-fit: cover;">
                                        <div class="p-4 flex flex-col justify-between">
                                            <h3 class="font-semibold text-gray-800 mb-2 truncate">
                                                {{ $product->productName }}</h3>
                                            <p class="text-[#FF5A4B] font-bold mb-3">R$
                                                {{ number_format($product->price, 2, ',', '.') }}</p>
                                            <div class="flex justify-between items-center">
                                                <a href="{{ route('product.edit', $product->id) }}"II
                                                    class="text-sm text-gray-600 hover:text-[#FF5A4B] transition">
                                                    Editar
                                                </a>
                                                <form action="{{ route('product.destroy', $product->id) }}"
                                                    method="POST" onsubmit="return confirm('Excluir este produto?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-500 hover:text-red-700 transition">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-8 pt-6 border-t border-gray-200">
                    <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Bazzar. Todos os direitos reservados.
                    </p>
                </div>

                <div x-show="isOpen" x-trap.noscroll x-transition.opacity @click="close()"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto" @click.stop>
                        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-t-2xl">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-bold">Editar Perfil</h3>
                                <button @click="close()" class="text-white hover:text-gray-200 text-2xl">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                            <p class="text-green-100 mt-1">Atualize suas informações pessoais</p>
                        </div>

                        <div class="p-6">
                            <form action="{{ route('user.update') }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                                    <input type="email" name="edit_email"
                                        value="{{ old('edit_email', $user_data->email) }}"
                                        class="w-full pl-3 pr-10 py-3 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B] transition">
                                    @error('edit_email')
                                        <div class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                                    <input type="text" name="edit_name"
                                        value="{{ old('edit_name', $user_data->user) }}"
                                        class="w-full pl-3 pr-10 py-3 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B] transition">
                                    @error('edit_name')
                                        <div class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div x-data="passwordToggle()" class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nova Senha <span class="text-gray-500 font-normal text-xs">(deixe em branco
                                            para
                                            manter
                                            a atual)</span>
                                    </label>
                                    <input :type="show ? 'text' : 'password'" name="edit_password"
                                        class="w-full pl-3 pr-10 py-3 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B] transition"
                                        placeholder="••••••••">
                                    <button type="button" @click="toggle()"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#FF5A4B]">
                                        <i :class="show ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                    </button>
                                    @error('edit_password')
                                        <div class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div x-data="passwordToggle()" class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Senha</label>
                                    <input :type="show ? 'text' : 'password'" name="edit_password_confirmation"
                                        class="w-full pl-3 pr-10 py-3 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-green-500 transition"
                                        placeholder="••••••••">
                                    <button type="button" @click="toggle()"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-green-100">
                                        <i :class="show ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                    </button>
                                </div>

                                <div class="flex gap-3 pt-2">
                                    <button type="button" @click="close()"
                                        class="flex-1 py-3 rounded-xl font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 transition">
                                        Cancelar
                                    </button>
                                    <button type="submit"
                                        class="flex-1 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-green-500 to-green-600 hover:brightness-110 transition shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                        <i class="bi bi-check-lg"></i> Salvar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const profileButton = document.getElementById('profileMenuButton');
        const profileMenu = document.getElementById('profileMenu');
        profileButton?.addEventListener('click', () => profileMenu.classList.toggle('hidden'));
    </script>
@endsection
