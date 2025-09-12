@extends ('layouts.main_layout')

@section('content')
    <div class="flex min-h-screen flex-col md:flex-row">
        <!-- Lado esquerdo (desktop) -->
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

            <h3 class="text-center text-2xl font-semibold mb-6">Crie sua conta</h3>

            <form action="{{ route('auth.cadastro') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="cadastro_name" class="block text-sm mb-1">Nome</label>
                    <input type="text" name="cadastro_name" value="{{ old('cadastro_name') }}"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B]"
                        placeholder="Seu nome completo">
                    @error('cadastro_name')
                        <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="cadastro_email" class="block text-sm mb-1">E-mail</label>
                    <input type="email" name="cadastro_email" value="{{ old('cadastro_email') }}"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B]"
                        placeholder="exemplo@email.com">
                    @error('cadastro_email')
                        <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="cadastro_password" class="block text-sm mb-1">Senha</label>
                    <div x-data="{ show: false }" class="relative">
                        <input :type="show ? 'text' : 'password'" name="cadastro_password"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B]"
                            placeholder="••••••••">
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-2/3 -translate-y-1/2 text-black text-xl cursor-pointer hover:text-[#FF5A4B] transition">
                            <i :class="show ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                    @error('cadastro_password')
                        <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="cadastro_password_confirmation" class="block text-sm mb-1">Confirmar Senha</label>
                    <div x-data="{ show: false }" class="relative">
                        <input :type="show ? 'text' : 'password'" name="cadastro_password_confirmation"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B]"
                            placeholder="••••••••">
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-2/3 -translate-y-1/2 text-black text-xl cursor-pointer hover:text-[#FF5A4B] transition">
                            <i :class="show ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                        class="w-full py-2 rounded-lg font-medium text-white 
                               bg-gradient-to-r from-[#FF3D3B] via-[#FF5A4B] to-[#FF7A66]
                               hover:brightness-110 transition cursor-pointer">
                        Criar Conta
                    </button>
                </div>
            </form>

            <div class="text-center text-lg mt-2">
                Já possui conta? <a href="{{ route('login') }}" class="text-[#FF5A4B] underline">Entrar</a><br>
            </div>
            <div class="text-center mt-6">
                <a href="{{ route('index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                    <i class="bi bi-arrow-left"></i> Voltar para a página principal
                </a>
            </div>
            
            <div class="mt-8 md:hidden">
                <h4 class="text-xl font-semibold mb-3 text-[#FF3D3B]">Por que escolher o Bazzar?</h4>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-center">
                        <i class="bi bi-cart-check-fill mr-2 text-[#FF3D3B]"></i>
                        Carrinho inteligente com total automático
                    </li>
                    <li class="flex items-center">
                        <i class="bi bi-heart-fill mr-2 text-[#FF3D3B]"></i>
                        Wishlist para produtos favoritos
                    </li>
                    <li class="flex items-center">
                        <i class="bi bi-shield-lock-fill mr-2 text-[#FF3D3B]"></i>
                        Segurança e autenticação confiável
                    </li>
                </ul>
            </div>
            <div class="text-center mt-6 text-xs text-gray-400">
                &copy; {{ date('Y') }} Bazzar
            </div>
        </div>
    </div>
@endsection
