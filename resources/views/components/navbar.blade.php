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
            class="p-4 absolute top-18 right-6 mt-2 bg-white rounded-lg inset-shadow-sm flex flex-col hidden z-10">
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
            <button id="profileMenuButton"
                class="flex items-center cursor-pointer gap-2 font-semibold md:p-3 rounded-lg md:text-2xl text-gray-700 hover:text-[#FF5A4B] hover:bg-gray-200 transition">
                <i class="bi bi-person-fill"></i> Perfil
            </button>
        </div>

        <div id="profileMenu"
            class="p-4 absolute top-18 right-6 mt-2 bg-white rounded-lg inset-shadow-sm flex flex-col hidden z-10">
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
            class="p-4 absolute top-18 right-6 mt-2 bg-white rounded-lg inset-shadow-sm flex flex-col hidden z-10">
            <a href="{{ route('user.show') }}"
                class="flex items-center gap-2 px-4 py-2 text-gray-700 rounded-lg hover:text-[#FF5A4B] hover:bg-gray-100 transition">
                <i class="bi bi-person"></i> Perfil
            </a>
            <a href="{{ route('logout') }}"
                class="flex items-center gap-2 px-4 py-2 text-red-500 rounded-lg hover:text-white hover:bg-red-700 transition">
                <i class="bi bi-box-arrow-in-left"></i> Logout
            </a>
        </div>
    @endif

</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const profileButton = document.getElementById('profileMenuButton');
        const profileMenu = document.getElementById('profileMenu');

        if (mobileButton && mobileMenu) {
            mobileButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                if (profileMenu) {
                    profileMenu.classList.add(
                    'hidden');
                }
            });
        }

        if (profileButton && profileMenu) {
            profileButton.addEventListener('click', () => {
                profileMenu.classList.toggle('hidden');
                if (mobileMenu) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }
    });
</script>
