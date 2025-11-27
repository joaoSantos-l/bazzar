@extends('layouts.main_layout')

@section('content')
    @include('components.navbar', ['cartSummary' => $cartSummary])

    <div class="container mx-auto px-4 py-8 min-h-screen" x-data="checkout()">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Finalizar Compra (Checkout POC)</h1>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/3">
                <div class="bg-white shadow-md rounded-lg p-6 space-y-6">

                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">1. Endereço de Entrega</h2>

                    <form class="space-y-4" action="{{ route('order.store') }}" method="POST" id="submit-order-form">
                        @csrf
                        
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                            <input type="text" id="full_name" name="full_name" placeholder="Seu nome"
                                value="{{ old('full_name') }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                            @error('full_name')
                                <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="cep" class="block text-sm font-medium text-gray-700">CEP</label>
                            <input type="text" id="cep" name="cep" placeholder="00000-000"
                                value="{{ old('cep') }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                            @error('cep')
                                <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="street" class="block text-sm font-medium text-gray-700">Endereço</label>
                            <input type="text" id="street" name="street" placeholder="Rua, Avenida, etc."
                                value="{{ old('street') }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                            @error('street')
                                <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="number" class="block text-sm font-medium text-gray-700">Número</label>
                                <input type="text" id="number" name="number" placeholder="123"
                                    value="{{ old('number') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                @error('number')
                                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="complement" class="block text-sm font-medium text-gray-700">Complemento
                                    (Opcional)</label>
                                <input type="text" id="complement" name="complement" placeholder="Apto, Bloco, etc."
                                    value="{{ old('complement') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            @error('complement')
                                <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4" x-data="location()">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">Cidade</label>
                                <select id="city" name="city" x-model="selectedCity"
                                    :disabled="!selectedState || loading.cities"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected x-text="getCityPlaceholder()"></option>
                                    <template x-for="city in cities" :key="city.id">
                                        <option :value="city.nome" x-text="city.nome"></option>
                                    </template>
                                </select>
                                @error('city')
                                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700">Estado</label>
                                <select id="state" name="state" x-model="selectedState" @change="loadCities(); $dispatch('state-changed', { state_uf: selectedState })"
                                    :disabled="loading.states"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected
                                        x-text="loading.states ? 'Carregando estados...' : 'Selecione seu Estado'"></option>
                                    <template x-for="state in states" :key="state.id">
                                        <option :value="state.sigla" x-text="state.nome"></option>
                                    </template>
                                </select>
                                @error('state')
                                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 pt-4">2. Método de Pagamento (POC)</h2>

                        <div>
                            <label for="card_number" class="block text-sm font-medium text-gray-700">Número do
                                Cartão</label>
                            <input type="text" id="card_number" name="card_number" placeholder="XXXX XXXX XXXX XXXX"
                                value="{{ old('card_number') }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('card_number')
                                <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <label for="card_name" class="block text-sm font-medium text-gray-700">Nome no
                                    Cartão</label>
                                <input type="text" id="card_name" name="card_name" placeholder="Nome impresso no cartão"
                                    value="{{ old('card_name') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('card_name')
                                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123"
                                    value="{{ old('cvv') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('cvv')
                                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700">Data de
                                Validade</label>
                            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/AA"
                                value="{{ old('expiry_date') }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('expiry_date')
                                <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:w-1/4">
                <div class="bg-white shadow-md rounded-lg p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Resumo do Pedido</h2>
                    <div class="space-y-2 text-gray-700">
                        
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span>R$ {{ number_format($cartSummary->total_price ?? 0, 2, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span>Frete:</span>
                            <span x-text="formatCurrency(shippingCost)"></span>
                        </div>
                        
                        <div class="flex justify-between font-bold text-lg pt-2 mt-2 border-t border-gray-200">
                            <span>Total: R$</span>
                            <span x-text="formatCurrency(totalAmount)"></span>
                        </div>
                        
                    </div>
                    <button type="submit" form="submit-order-form"
                        class="mt-6 w-full block text-center px-6 py-3 bg-[#FF5A4B] text-white font-semibold rounded-lg shadow hover:brightness-110 transition">
                        Confirmar Compra
                    </button>
                    <p class="text-xs text-center text-gray-500 mt-2">Ao clicar em "Confirmar Pedido", você concorda com os
                        termos de serviço (POC).</p>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')

    <script>
        function checkout() {
            const SHIPPING_RATES = @json(config('shipping.rates', []));
            const DEFAULT_RATE = {{ config('shipping.default_rate', 50.00) }};
            const CART_SUBTOTAL = {{ $cartSummary->total_price ?? 0 }};

            return {
                shippingCost: DEFAULT_RATE,
                subtotal: CART_SUBTOTAL,

                get totalAmount() {
                    return this.subtotal + this.shippingCost;
                },

                formatCurrency(amount) {
                    return new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL',
                        minimumFractionDigits: 2
                    }).format(amount);
                },

                init() {
                    this.$root.addEventListener('state-changed', (event) => {
                        this.calculateShipping(event.detail.state_uf);
                    });
                },

                calculateShipping(stateUF) {
                    const normalizedState = stateUF ? stateUF.toUpperCase() : null;

                    if (normalizedState && SHIPPING_RATES[normalizedState]) {
                        this.shippingCost = SHIPPING_RATES[normalizedState];
                    } else {
                        this.shippingCost = DEFAULT_RATE;
                    }
                }
            }
        }
    </script>
@endsection