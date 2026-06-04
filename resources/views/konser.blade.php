<x-layout>

    {{-- ══ Search Bar ═══════════════════════════════════════════════════════ --}}
    <div class="border-b border-gray-100 bg-white">
        <div class="max-w-4xl mx-auto px-4 py-4">
            <form method="GET" action="/konser" id="search-form">
                <div class="flex flex-col md:flex-row gap-3">

                    {{-- Keyword --}}
                    <div class="flex-1 flex items-center px-4 py-2.5 bg-white rounded-xl border border-gray-200 focus-within:border-blue-400 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input
                            type="text"
                            name="q"
                            value="{{ $keyword }}"
                            placeholder="Nama artis atau konser…"
                            class="w-full bg-transparent border-none focus:ring-0 text-sm outline-none text-gray-700 placeholder-gray-400"
                            autocomplete="off"
                        >
                        @if($keyword)
                            <button type="button" onclick="clearInput('q', this)" class="text-gray-300 hover:text-gray-500 ml-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        @endif
                    </div>

                    {{-- Bulan --}}
                    <div class="flex items-center px-4 py-2.5 bg-white rounded-xl border border-gray-200 focus-within:border-blue-400 transition-colors min-w-[170px]">
                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <select name="month" class="w-full bg-transparent border-none focus:ring-0 text-sm text-gray-600 appearance-none outline-none cursor-pointer" onchange="document.getElementById('search-form').submit()">
                            <option value="">Semua Bulan</option>
                            @foreach($availableMonths as $m)
                                <option value="{{ $m['month_key'] }}" {{ $month === $m['month_key'] ? 'selected' : '' }}>
                                    {{ $m['month_label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kota --}}
                    <div class="flex items-center px-4 py-2.5 bg-white rounded-xl border border-gray-200 focus-within:border-blue-400 transition-colors min-w-[170px]">
                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <select name="city" class="w-full bg-transparent border-none focus:ring-0 text-sm text-gray-600 appearance-none outline-none cursor-pointer" onchange="document.getElementById('search-form').submit()">
                            <option value="">Semua Kota</option>
                            @foreach($cities as $c)
                                <option value="{{ $c }}" {{ $city === $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Cari --}}
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition-colors flex items-center gap-2 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>

                </div>

                {{-- Active filter pills --}}
                @if($hasFilter)
                    <div class="flex flex-wrap items-center gap-2 mt-3">
                        <span class="text-xs text-gray-400 font-medium">Filter aktif:</span>

                        @if($keyword)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                                "{{ $keyword }}"
                                <a href="{{ request()->fullUrlWithQuery(['q' => '']) }}" class="hover:text-blue-900">×</a>
                            </span>
                        @endif

                        @if($month)
                            @php $mLabel = collect($availableMonths)->firstWhere('month_key', $month)['month_label'] ?? $month; @endphp
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-semibold">
                                📅 {{ $mLabel }}
                                <a href="{{ request()->fullUrlWithQuery(['month' => '']) }}" class="hover:text-purple-900">×</a>
                            </span>
                        @endif

                        @if($city)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">
                                📍 {{ $city }}
                                <a href="{{ request()->fullUrlWithQuery(['city' => '']) }}" class="hover:text-green-900">×</a>
                            </span>
                        @endif

                        <a href="/konser" class="text-xs text-gray-400 hover:text-red-500 font-medium ml-1 transition-colors">Hapus semua filter</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- ══ Daftar Konser ══════════════════════════════════════════════════════ --}}
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                @if($hasFilter)
                    <h1 class="text-2xl font-extrabold text-gray-900">
                        Hasil Pencarian
                        <span class="text-base font-normal text-gray-400 ml-2">({{ $concerts->count() }} konser ditemukan)</span>
                    </h1>
                @else
                    <h1 class="text-2xl font-extrabold text-gray-900">Koleksi Konser</h1>
                    <p class="text-gray-500 text-sm mt-1">{{ $concerts->count() }} konser aktif tersedia</p>
                @endif
            </div>

            @if($concerts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                    @foreach($concerts as $concert)
                        <x-concert-card :concert="$concert" />
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="py-20 text-center">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    @if($hasFilter)
                        <h3 class="text-lg font-bold text-gray-700 mb-2">Tidak ada konser yang cocok</h3>
                        <p class="text-sm text-gray-400 max-w-sm mx-auto mb-5">
                            Coba ubah kata kunci, bulan, atau kota yang kamu cari.
                        </p>
                        <a href="/konser" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors text-sm">
                            Lihat Semua Konser
                        </a>
                    @else
                        <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Konser Tersedia</h3>
                        <p class="text-sm text-gray-400 max-w-md mx-auto mb-5">
                            Saat ini belum ada konser aktif. Silakan kembali nanti!
                        </p>
                        <a href="/" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors text-sm">
                            Kembali ke Beranda
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    {{-- ══ Paling Diminati (hanya tampil jika tidak ada filter aktif) ══════════ --}}
    @if(!$hasFilter && $popularConcerts->count() > 0)
    <section class="py-12 bg-white border-t border-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Paling Diminati Minggu Ini</h2>
                <p class="text-gray-500 text-sm">Jelajahi berbagai pengalaman musik terbaik.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($popularConcerts as $concert)
                    <x-concert-card :concert="$concert" buttonText="Lihat Ketersediaan" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <script>
        function clearInput(name, btn) {
            const form = document.getElementById('search-form');
            const input = form.querySelector('[name="' + name + '"]');
            if (input) { input.value = ''; }
            btn.closest('.flex').style.display = 'none';
            form.submit();
        }
    </script>

</x-layout>
