@extends('layouts.main_layout')

@section('content')
    <div class="min-h-screen flex flex-col bg-gray-50">

        <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center relative">
            <div class="flex items-center gap-2">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16">
                </a>
            </div>

            @if (session()->missing('user'))
                <div class="hidden md:flex gap-2">
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-2 font-semibold md:p-3 rounded-lg md:text-2xl text-gray-700 hover:text-[#FF5A4B] hover:bg-gray-200 transition">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="flex items-center gap-2 font-semibold md:p-3 rounded-lg md:text-2xl text-gray-700 hover:text-[#FF5A4B] hover:bg-gray-200 transition">
                        <i class="bi bi-person-plus-fill"></i> Cadastro
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
            @elseif(session()->has('user'))
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
            @endif

        </nav>

        <section
            class="flex flex-col md:flex-row items-center justify-between px-6 md:px-10 py-16 md:py-32 bg-gradient-to-r from-[#FF3D3B] via-[#FF5A4B] to-[#FF7A66] text-white gap-10">

            <div class="max-w-md text-center md:text-left flex-shrink-0">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Bem-vindo ao Bazzar</h1>
                <p class="text-lg mb-6 leading-relaxed">
                    A plataforma completa de e-commerce para gerenciar produtos, carrinho, wishlist e muito mais.
                </p>
                <a href="{{ route('register') }}"
                    class="inline-block px-6 py-3 bg-white text-[#FF5A4B] font-semibold rounded-lg shadow hover:brightness-110 transition">
                    Comece Agora
                </a>
            </div>

            <div x-data="carousel()" x-init="start()" class="w-full md:w-1/2 relative overflow-hidden">
                <div class="flex transition-transform duration-700" :style="`transform: translateX(-${controle * 100}%);`">
                    <template x-for="slide in slides" :key="slide.title">
                        <div class="flex-shrink-0 w-full flex items-center justify-center">
                            <img :src="slide.image" alt="" class="h-64 md:h-80 rounded-xl shadow-lg">
                        </div>
                    </template>
                </div>

                <button @click="prev()"
                    class="cursor-pointer absolute left-2 top-1/2 -translate-y-1/2 bg-white text-[#FF5A4B] rounded-full p-2 shadow hover:bg-gray-200 transition">
                    <i class="bi bi-chevron-left text-2xl"></i>
                </button>
                <button @click="next()"
                    class="cursor-pointer absolute right-2 top-1/2 -translate-y-1/2 bg-white text-[#FF5A4B] rounded-full p-2 shadow hover:bg-gray-200 transition">
                    <i class="bi bi-chevron-right text-2xl"></i>
                </button>

                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <span @click="goTo(index)" class="w-3 h-3 rounded-full bg-white opacity-50 cursor-pointer"
                            :class="{ 'opacity-100': controle === index }"></span>
                    </template>
                </div>
            </div>
        </section>

        </section>

        <section class="px-6 md:px-10 py-16">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Recursos do Bazzar</h2>

            <div class="flex gap-6 overflow-x-auto pb-4">
                @foreach ([['icon' => 'bi-check-circle-fill', 'title' => 'Cadastro de Produtos', 'text' => 'Adicione imagens, nomes, preços, categorias e estoque de forma rápida e fácil.'], ['icon' => 'bi-people-fill', 'title' => 'Gestão de Usuários', 'text' => 'Controle acessos e permissões dos seus usuários de forma simples.'], ['icon' => 'bi-cart-fill', 'title' => 'Carrinho Inteligente', 'text' => 'Cálculo automático do total e gerenciamento do pedido em tempo real.'], ['icon' => 'bi-heart-fill', 'title' => 'Wishlist', 'text' => 'Salve seus produtos favoritos e acesse rapidamente quando quiser.'], ['icon' => 'bi-shield-lock-fill', 'title' => 'Segurança Avançada', 'text' => 'Autenticação confiável e proteção de dados para você e seus clientes.'], ['icon' => 'bi-headset', 'title' => 'Suporte Dedicado', 'text' => 'Equipe pronta para ajudar em qualquer problema de forma rápida e eficiente.']] as $feature)
                    <div
                        class="flex-shrink-0 w-80 p-6 bg-white rounded-xl shadow hover:shadow-lg transition flex flex-col items-center text-center">
                        <i class="bi {{ $feature['icon'] }} text-3xl text-[#FF5A4B] mb-4"></i>
                        <h3 class="font-semibold mb-2">{{ $feature['title'] }}</h3>
                        <p>{{ $feature['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <footer class="bg-white mt-auto py-6 text-center text-gray-400">
            &copy; {{ date('Y') }} Bazzar. Todos os direitos reservados.
        </footer>

    </div>

    <script>
        const mobileButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        const profileButton = document.getElementById('profileMenuButton');
        const profileMenu = document.getElementById('profileMenu');

        profileButton.addEventListener('click', () => {
            profileMenu.classList.toggle('hidden');
        });
    </script>
@endsection
