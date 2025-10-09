@extends('layouts.main_layout')

@section('content')
    <div class="flex min-h-screen">
        <!-- Lado esquerdo (desktop)-->
        <div
            class="hidden md:flex flex-col justify-center items-start p-10 w-1/2 
               bg-gradient-to-br from-[#FF3D3B] via-[#FF5A4B] to-[#FF7A66] text-white">
            <h2 class="text-5xl font-bold mb-4">Bazzar</h2>
            <p class="mb-6 text-2xl max-w-lg leading-snug">
                O <span class="text-orange-200 font-semibold">Bazzar</span> é uma plataforma de e-commerce
                que oferece uma experiência <span class="font-semibold">completa, segura e confiável</span> para seus
                usuários, garantindo
                que tudo corra bem desde a compra até a entrega.
            </p>
            <ul class="space-y-3 text-white text-[19px]">
                <li class="flex items-center">
                    <i class="bi bi-cart-check-fill mr-2 text-orange-200"></i>
                    Carrinho inteligente com cálculo automático do total
                </li>
                <li class="flex items-center">
                    <i class="bi bi-people-fill mr-2 text-orange-200"></i>
                    Gestão de usuários com diferentes níveis de acesso
                </li>
                <li class="flex items-center">
                    <i class="bi bi-box-seam-fill mr-2 text-orange-200"></i>
                    Cadastro e controle completo de produtos
                </li>
                <li class="flex items-center">
                    <i class="bi bi-heart-fill mr-2 text-orange-200"></i>
                    Wishlist para salvar seus produtos favoritos
                </li>
                <li class="flex items-center">
                    <i class="bi bi-shield-lock-fill mr-2 text-orange-200"></i>
                    Segurança avançada com autenticação confiável
                </li>
                <li class="flex items-center">
                    <i class="bi bi-phone-fill mr-2 text-orange-200"></i>
                    Design responsivo para qualquer dispositivo
                </li>
                <li class="flex items-center">
                    <i class="bi bi-headset mr-2 text-orange-200"></i>
                    Suporte dedicado e fácil de acessar
                </li>
            </ul>
        </div>

        <!-- Lado direito -->
        <div class="flex flex-col justify-center w-full md:w-1/2 bg-white text-black p-10">
            <div class="text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 mx-auto">
            </div>

            <h3 class="text-center text-2xl font-semibold mb-6">Acesse sua conta</h3>

            <form action="{{ route('auth.login') }}" method="POST" class="space-y-4">

                @csrf
                <div class="text-center mt-6">
                    @if (session('login-error'))
                        <div
                            class="justify-center inline-flex bg-[#FF3D3B] text-white font-semibold text 2xl w-1/2 rounded-lg p-4">
                            {{ session('login-error') }}
                        </div>
                    @endif
                </div>

                <div>
                    <label for="login_email" class="block text-sm mb-1">E-mail</label>
                    <input type="email" name="login_email" value="{{ old('login_email') }}"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B]"
                        placeholder="exemplo@email.com">
                    @error('login_email')
                        <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div x-data="{ show: false }" class="relative">
                    <label for="login_password" class="block text-sm mb-1">Senha</label>
                    <input :type="show ? 'text' : 'password'" name="login_password"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B]"
                        placeholder="••••••••">
                    <button type="button" @click="show = !show"
                        class="absolute right-3 top-2/3 -translate-y-1/2 text-black text-xl cursor-pointer hover:text-[#FF5A4B] transition">
                        <i :class="show ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                    </button>
                    @error('login_password')
                        <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-2 rounded-lg font-medium text-white 
                               bg-gradient-to-r from-[#FF3D3B] via-[#FF5A4B] to-[#FF7A66]
                               hover:brightness-110 transition cursor-pointer">
                    Entrar
                </button>
            </form>
            <div class="text-center text-lg mt-2"> Não possui conta? <a href="{{ route('cadastro') }}"
                    class="text-[#FF5A4B] underline">Cadastre-se</a><br>
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                    <i class="bi bi-arrow-left"></i> Voltar para a página principal
                </a>
            </div>
            <div class="text-center mt-6 text-xs text-gray-400">
                &copy; {{ date('Y') }} Bazzar
            </div>
        </div>
    </div>
@endsection
