@extends('layouts.main_layout')

@section('content')
    <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center sticky top-0 z-50">
        <div class="hidden md:flex items-center gap-2">
            <a href="{{ route('index') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14">
            </a>

        </div>

        <div class="flex items-center gap-4">

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
                <a href="{{ route('admin.users') }}"
                    class="flex items-center cursor-pointer gap-2 font-semibold md:p-3 rounded-lg md:text-2xl text-[#FF5A4B] hover:text-[#FF5A4B] hover:bg-gray-200 transition">
                    <i class="bi bi-people-fill"></i> Usuários
                </a>
            </div>

            <div class="hidden md:flex gap-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center cursor-pointer gap-2 font-semibold md:p-3 rounded-lg md:text-2xl text-gray-700 hover:text-[#FF5A4B] hover:bg-gray-200 transition">
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
                    <h1 class="text-3xl font-bold text-gray-800">Gerenciamento de Usuários</h1>
                </div>

                <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Lista de Usuários</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Usuário
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Função
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Ações</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->user }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->email }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($user->admin)
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Admin
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Usuário
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <form action="{{ route('admin.users.sudo', $user->id) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="text-black p-2 transition cursor-pointer"
                                                        title="{{ $user->admin ? 'Tirar Admin' : 'Tornar Admin' }}">

                                                        @if ($user->admin)
                                                            <i class="bi bi-shield-slash text-lg"></i>
                                                        @else
                                                            <i class="bi bi-shield-lock text-lg"></i>
                                                        @endif

                                                    </button>
                                                </form>

                                                <a href="{{ route('admin.users', $user->id) }}" class="text-[#FF5A4B] p-2"
                                                    title="Ver">
                                                    <i class="bi bi-eye text-lg"></i>
                                                </a>

                                                <a href="{{ route('index', $user->id) }}" class="text-[#FF5A4B] p-2"
                                                    title="Editar">
                                                    <i class="bi bi-pencil text-lg"></i>
                                                </a>

                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                    class="inline-block"
                                                    onsubmit="return confirm('Tem certeza que deseja deletar o usuário {{ $user->user }}?')">
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

            </div>
        </section>

        <div class="text-center mt-8 pt-6 border-t border-gray-200">
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Bazzar. Todos os direitos reservados.</p>
        </div>
    </div>

    <script>
        const profileButton = document.getElementById('profileMenuButton');
        const profileMenu = document.getElementById('profileMenu');
        profileButton?.addEventListener('click', () => profileMenu.classList.toggle('hidden'));
    </script>
@endsection
