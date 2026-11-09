<header class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="w-full px-6 lg:px-12 xl:px-16">
        <div class="h-20 grid grid-cols-3 items-center">

            {{-- LOGO --}}
            <div class="flex justify-start">
                <a href="{{ route('dashboard') }}"
                    class="text-2xl font-bold text-[#174b35]">
                    Sisa.in
                </a>
            </div>

            {{-- MENU NAVBAR --}}
            <nav class="hidden md:flex items-center justify-center gap-8 text-sm whitespace-nowrap">

                <a href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') && request('section') !== 'produk' ? 'font-semibold text-[#174b35]' : 'text-gray-500 hover:text-[#174b35]' }}">
                    Beranda
                </a>

                <a href="{{ route('dashboard', ['section' => 'produk']) }}#produk"
                    class="{{ request('section') === 'produk' ? 'font-semibold text-[#174b35]' : 'text-gray-500 hover:text-[#174b35]' }}">
                    Jelajahi
                </a>

                <a href="{{ route('orders.index') }}"
                    class="{{ request()->routeIs('orders.*') ? 'font-semibold text-[#174b35]' : 'text-gray-500 hover:text-[#174b35]' }}">
                    Pesanan
                </a>

            </nav>

            {{-- PROFIL DAN LOGOUT --}}
            <div class="flex items-center justify-end gap-3">

                <div class="hidden sm:block text-right">
                    <p class="text-sm font-semibold">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-400">Customer</p>
                </div>

                <div class="w-10 h-10 rounded-full bg-[#174b35] text-white flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            title="Logout"
                            class="text-gray-400 hover:text-red-500 ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="20" height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </button>
                </form>

            </div>

        </div>
    </div>
</header>
