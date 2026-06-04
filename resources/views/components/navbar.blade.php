@props(['type' => 'guest'])

<header class="border-b border-gray-200 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo & Portal Admin -->
            <div class="flex-shrink-0 flex items-center gap-6">
                <a href="/" class="flex items-center gap-2">
                    <svg class="h-8 w-8 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 5v2"></path>
                        <path d="M15 11v2"></path>
                        <path d="M15 17v2"></path>
                        <path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7a2 2 0 0 1 2-2z"></path>
                    </svg>
                    <span class="font-bold text-2xl tracking-tight text-gray-900">TICKETER</span>
                </a>
                
                @if($type === 'admin')
                    <a href="/admin" class="hidden md:inline-flex items-center justify-center px-4 py-1.5 border border-transparent text-sm font-semibold rounded-full text-white bg-blue-400 hover:bg-blue-500 transition-colors shadow-sm">
                        Portal Admin
                    </a>
                @endif
            </div>

            <!-- Navigation Links -->
            <nav class="hidden md:flex space-x-8">
                <a href="/" class="{{ request()->is('/') ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium' }} transition-colors">Beranda</a>
                <a href="/konser" class="{{ request()->is('konser') ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium' }} transition-colors">Konser</a>
                <a href="/artis" class="{{ request()->is('artis') ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium' }} transition-colors">Artis</a>
            </nav>

            <!-- Action Button -->
            <div class="flex items-center gap-4">
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
        </div>
    </div>
</header>
