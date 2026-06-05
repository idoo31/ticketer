@props(['type' => 'guest'])

<header class="border-b border-gray-200 bg-white sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20">
            <!-- Logo & Portal Admin -->
            <div class="flex-shrink-0 flex items-center gap-4">
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('logo.svg') }}" alt="Ticketer Logo" class="h-7 w-7 md:h-8 md:w-8">
                    <span class="font-bold text-xl md:text-2xl tracking-tight text-gray-900">TICKETER</span>
                </a>

                @if($type === 'admin')
                    <a href="/admin" class="hidden md:inline-flex items-center justify-center px-4 py-1.5 border border-transparent text-sm font-semibold rounded-full text-white bg-blue-400 hover:bg-blue-500 transition-colors shadow-sm">
                        Portal Admin
                    </a>
                @endif
            </div>

            <!-- Navigation Links (Desktop) -->
            <nav class="hidden md:flex space-x-8">
                <a href="/" class="{{ request()->is('/') ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium' }} transition-colors">Beranda</a>
                <a href="/konser" class="{{ request()->is('konser') ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium' }} transition-colors">Konser</a>
                <a href="/artis" class="{{ request()->is('artis') ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium' }} transition-colors">Artis</a>
            </nav>

            <!-- Action Button (Desktop) + Hamburger -->
            <div class="flex items-center gap-3">
                <!-- Desktop Buttons -->
                <div class="hidden md:flex items-center gap-3">
                    @if($type === 'guest')
                        <a href="/login" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 border border-transparent text-sm font-semibold rounded-full text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Masuk/Daftar
                        </a>
                    @else
                        <a href="{{ $type === 'admin' ? '/admin/akun' : '/akun' }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 border border-transparent text-sm font-semibold rounded-full text-white bg-blue-500 hover:bg-blue-600 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Akun saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 border border-red-50 text-sm font-semibold rounded-full text-red-600 hover:bg-red-50 transition-colors">
                                Keluar
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Hamburger Button (Mobile) -->
                <button id="navbar-hamburger" type="button"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors focus:outline-none"
                    aria-label="Buka menu navigasi">
                    <svg id="hamburger-icon" class="w-6 h-6 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="close-icon" class="w-6 h-6 hidden transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu"
        class="md:hidden overflow-hidden transition-all duration-300 ease-in-out max-h-0 opacity-0">
        <div class="bg-white border-t border-gray-100 px-4 py-4 space-y-1">
            <!-- Nav Links -->
            <a href="/" class="{{ request()->is('/') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="/konser" class="{{ request()->is('konser') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 012 2v3a2 2 0 000 4v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3a2 2 0 000-4V7a2 2 0 012-2z"/></svg>
                Konser
            </a>
            <a href="/artis" class="{{ request()->is('artis') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Artis
            </a>

            <!-- Divider -->
            <div class="border-t border-gray-100 my-2"></div>

            <!-- Auth Actions -->
            @if($type === 'guest')
                <a href="/login" class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Masuk / Daftar
                </a>
            @else
                <a href="{{ $type === 'admin' ? '/admin/akun' : '/akun' }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-700 rounded-xl text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Akun Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl text-sm font-semibold transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
                @if($type === 'admin')
                    <div class="border-t border-gray-100 pt-2">
                        <a href="/admin" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl text-sm font-semibold transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Portal Admin
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>
</header>

<script>
    (function () {
        const btn = document.getElementById('navbar-hamburger');
        const menu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');
        let isOpen = false;

        btn.addEventListener('click', function () {
            isOpen = !isOpen;
            if (isOpen) {
                menu.style.maxHeight = menu.scrollHeight + 'px';
                menu.style.opacity = '1';
                hamburgerIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                menu.style.maxHeight = '0';
                menu.style.opacity = '0';
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
    })();
</script>
