<x-layout>
    {{-- Top Search Bar --}}
    <div class="border-b border-gray-100 bg-white">
        <div class="max-w-2xl mx-auto px-4 py-6">
            <form method="GET" action="{{ route('artis.index') }}">
                <div class="flex items-center px-4 py-3 bg-white rounded-xl border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all">
                    <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="q" value="{{ $keyword }}"
                           placeholder="Ketik nama artis atau band"
                           class="w-full bg-transparent border-none focus:ring-0 text-gray-900 placeholder-gray-500 text-sm outline-none">
                    @if($keyword)
                        <a href="{{ route('artis.index') }}" class="text-gray-400 hover:text-gray-600 ml-2 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Artists Section --}}
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-3">Eksplorasi Artis</h1>
                <p class="text-gray-600">Temukan jadwal tour lineup musik paling ikonik sedunia.</p>
            </div>

            @if($artists->isNotEmpty())
                {{-- Result count if searching --}}
                @if($keyword)
                    <p class="text-sm text-gray-500 mb-6 text-center">
                        Menampilkan <strong>{{ $artists->count() }}</strong> artis untuk "<strong>{{ $keyword }}</strong>"
                    </p>
                @endif

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                    @foreach($artists as $artist)
                        <x-artist-card
                            :image="$artist->image_url ? image_url($artist->image_url) : null"
                            :name="$artist->name"
                            :genre="$artist->genre"
                            :origin="$artist->origin"
                        />
                    @endforeach
                </div>
            @else
                {{-- Empty state --}}
                <div class="text-center py-24">
                    <svg class="w-20 h-20 text-gray-200 mx-auto mb-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    @if($keyword)
                        <p class="text-gray-500 font-semibold text-lg mb-2">Artis tidak ditemukan</p>
                        <p class="text-gray-400 text-sm mb-6">Tidak ada artis dengan nama "<strong>{{ $keyword }}</strong>".</p>
                        <a href="{{ route('artis.index') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                            Lihat Semua Artis
                        </a>
                    @else
                        <p class="text-gray-500 font-semibold text-lg mb-2">Belum ada artis</p>
                        <p class="text-gray-400 text-sm">Data artis akan muncul setelah admin menambahkannya.</p>
                    @endif
                </div>
            @endif
        </div>
    </section>
</x-layout>
