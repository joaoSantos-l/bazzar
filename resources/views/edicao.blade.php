@extends('layouts.main_layout')

@section('content')
    <div class="flex min-h-screen">
        <!-- Lado esquerdo (desktop)-->
        <div
            class="hidden md:flex flex-col justify-center items-start p-10 w-1/2 
               bg-gradient-to-br from-[#FF3D3B] via-[#FF5A4B] to-[#FF7A66] text-white">
            <h2 class="text-5xl font-bold mb-4">Bazzar</h2>
           
        </div>

        <!-- Lado direito -->
        <div class="flex flex-col justify-center w-full md:w-1/2 bg-white text-black p-10">
            <div class="text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 mx-auto">
            </div>

            <h3 class="text-center text-2xl font-semibold mb-6">Edite suas informações</h3>

            <form action="{{ route('auth.edit') }}" method="POST" class="space-y-4">

                @csrf
                <div class="text-center mt-6">
                    @if (session('edit-error'))
                        <div
                            class="justify-center inline-flex bg-[#FF3D3B] text-white font-semibold text 2xl w-1/2 rounded-lg p-4">
                            {{ session('edit-error') }}
                        </div>
                    @endif
                </div>

                <div>
                    <label for="edit_email" class="block text-sm mb-1">E-mail</label>
                    <input type="email" name="edit_email" value="{{ $usuario_data->email }}"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B]"
                        placeholder="exemplo@email.com">
                    @error('edit_email')
                        <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="edit_nome" class="block text-sm mb-1">Nome</label>
                    <input type="text" name="edit_nome" value="{{ $usuario_data->user }}"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B]">
                    @error('edit_nome')
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
                    @error('edit_password')
                        <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="edit_password_confirmation" class="block text-sm mb-1">Confirmar Senha</label>
                    <div x-data="{ show: false }" class="relative">
                        <input :type="show ? 'text' : 'password'" name="edit_password_confirmation"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-[#FF5A4B]"
                            placeholder="••••••••">
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-2/3 -translate-y-1/2 text-black text-xl cursor-pointer hover:text-[#FF5A4B] transition">
                            <i :class="show ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-2 rounded-lg font-medium text-white 
                               bg-gradient-to-r from-[#FF3D3B] via-[#FF5A4B] to-[#FF7A66]
                               hover:brightness-110 transition cursor-pointer">
                    Confirmar
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('profile') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                    <i class="bi bi-arrow-left"></i> Voltar para página de perfil
                </a>
            </div>
            <div class="text-center mt-6 text-xs text-gray-400">
                &copy; {{ date('Y') }} Bazzar
            </div>
        </div>
    </div>
@endsection
