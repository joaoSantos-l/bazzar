@extends('layouts.main_layout')

@section('content')
    <div class="flex min-h-screen">

        <div
            class="hidden md:flex flex-col justify-center items-start p-10 w-1/3
               bg-gradient-to-br from-[#FF7A66] via-[#FF5A4B] to-[#FF3D3B] text-white">
        </div>
        <div class="flex flex-col items-center justify-center w-1/2 bg-white text-black p-10">
            <div class="text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 mx-auto">
            </div>

            <h3 class="text-center text-2xl font-semibold mb-6">Seu perfil</h3>

            <ul class="space-y-3 text-black text-[19px]">
                <li class="flex items-center">
                    Nome de Usuario: {{ $usuario_data->user }}
                </li>
                <li class="flex items-center">
                    Email: {{ $usuario_data->email }}
                </li>
            </ul>

            <div class="flex gap-2">
                <div class="w-1/2  text-center mt-6">
                    <a href="{{ route('editShow') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-500 text-gray-700 hover:bg-gray-300 transition">
                        Editar
                    </a>
                </div>

                <div class="w-1/2 text-center mt-6">
                    <a href="{{ route('delete') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-500 text-gray-700 hover:bg-gray-300 transition">
                        Deletar
                    </a>
                </div>
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
        <div
            class="hidden md:flex flex-col justify-center items-start p-10 w-1/3
               bg-gradient-to-br from-[#FF3D3B] via-[#FF5A4B] to-[#FF7A66] text-white">
        </div>
    </div>
    </div>
@endsection
