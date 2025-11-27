@if ($products->isEmpty())
    <div class="p-4 text-gray-500 text-center">
        Nenhum produto encontrado para "{{ request('q') }}"
    </div>
@else
    <div class="flex flex-col divide-y divide-gray-100 py-1">
        @foreach ($products as $product)
            <a href="{{ route('index') }}" @click="selectProduct()"
                class="flex items-center gap-4 p-3 hover:bg-gray-100 transition duration-150 ease-in-out cursor-pointer">

                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Img"
                    class="w-10 h-10 object-cover rounded shadow-sm flex-shrink-0">

                <div class="flex-grow min-w-0">

                    <h4 class="font-medium text-gray-800 truncate block w-full">{{ $product->productName }}</h4>
                    <p class="text-gray-500 truncate block w-full">{{ $product->seller }}</p>

                    <p class="text-[#FF5A4B] font-bold text-sm">R$ {{ number_format($product->price ?? 0, 2, ',', '.') }}</p>
                </div>

                <i class="bi bi-chevron-right text-gray-400 text-sm ml-auto flex-shrink-0"></i>
            </a>
        @endforeach
    </div>

    <div class="p-2 text-center border-t border-gray-100">
        <a href="{{ route('index', ['q' => request('q')]) }}" @click="selectProduct()"
            class="text-[#FF5A4B] font-semibold text-sm hover:underline">
            Ver todos os resultados para "{{ request('q') }}"
        </a>
    </div>
@endif
