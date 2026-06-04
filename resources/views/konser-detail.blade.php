<x-layout>
<div class="bg-slate-50 min-h-screen pb-12">

    {{-- ── Breadcrumb ── --}}
    <div class="bg-white border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-blue-500 transition-colors">Beranda</a>
                <span class="text-slate-300">›</span>
                <a href="/konser" class="hover:text-blue-500 transition-colors">Konser</a>
                <span class="text-slate-300">›</span>
                <span class="text-slate-600 font-medium truncate">{{ $concert->title }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        {{-- ── Header ── --}}
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 mb-3">{{ $concert->title }}</h1>
            @if($concert->artists->isNotEmpty())
                <div class="flex flex-wrap items-center gap-3 mt-2">
                    @foreach($concert->artists as $artist)
                        <div class="flex items-center gap-2 bg-blue-50 rounded-full pr-4 p-1 border border-blue-100">
                            @if($artist->image_url)
                                <img src="{{ Storage::url($artist->image_url) }}" alt="{{ $artist->name }}"
                                     class="w-8 h-8 rounded-full object-cover border-2 border-blue-200 shrink-0">
                            @else
                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center shrink-0 text-xs font-bold text-white">
                                    {{ strtoupper(substr($artist->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-blue-900 text-xs sm:text-sm m-0 leading-tight">{{ $artist->name }}</p>
                                @if($artist->genre)
                                    <p class="text-[10px] sm:text-xs text-blue-400 m-0">{{ $artist->genre }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ── Two-Column Layout ── --}}
        <div class="flex flex-col md:flex-row gap-6 lg:gap-8 items-start">

            {{-- LEFT COLUMN --}}
            <div class="flex-1 min-w-0 w-full">

                {{-- Concert Info Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden flex flex-col sm:flex-row mb-6 sm:mb-8 shadow-sm">
                    {{-- Banner --}}
                    <div class="w-full sm:w-48 md:w-64 h-48 sm:h-auto bg-slate-100 shrink-0 overflow-hidden relative">
                        @if($concert->banner_url)
                            <img src="{{ Storage::url($concert->banner_url) }}" alt="{{ $concert->title }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 012 2v3a2 2 0 000 4v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3a2 2 0 000-4V7a2 2 0 012-2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    {{-- Date & Venue --}}
                    <div class="flex-1 p-5 sm:p-6 lg:p-8 flex flex-col justify-center gap-4 sm:gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-slate-900 text-sm sm:text-base mb-0.5">{{ $concert->event_date->translatedFormat('l, d F Y') }}</p>
                                <p class="text-xs sm:text-sm text-slate-400 m-0">{{ $concert->event_time ?? '19.00' }} WIB</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-cyan-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-slate-900 text-sm sm:text-base mb-0.5">{{ $concert->venue_name }}</p>
                                <p class="text-xs sm:text-sm text-slate-400 m-0">{{ $concert->city }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Section: Pilih Kategori Tiket ── --}}
                <div class="flex items-center gap-3 mb-4 sm:mb-5">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md shadow-blue-500/30">1</div>
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 m-0">Pilih Kategori Tiket</h2>
                </div>

                <form method="POST" action="{{ route('checkout.cart.save', $concert) }}" id="ticket-form">
                    @csrf

                    @if($errors->any())
                        <div class="mb-4 sm:mb-5 bg-red-50 border border-red-200 text-red-600 rounded-xl p-3 sm:p-4 text-sm flex items-center gap-2">
                            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="flex flex-col gap-3 mb-6 sm:mb-8">
                        @forelse($concert->ticketCategories as $cat)
                            <div id="row-{{ $cat->id }}" class="bg-white rounded-xl sm:rounded-2xl border-2 border-slate-100 p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all duration-200 hover:border-blue-200 hover:shadow-md hover:shadow-blue-500/5 shadow-sm">
                                <div>
                                    <p class="font-bold text-slate-900 text-sm sm:text-base mb-1">{{ $cat->category_name }}</p>
                                    <p class="text-xs sm:text-sm text-slate-400 m-0">{{ $cat->available_quota }} tiket tersedia</p>
                                </div>
                                <div class="flex items-center justify-between sm:justify-end gap-4 sm:gap-6 border-t sm:border-t-0 border-slate-100 pt-3 sm:pt-0 mt-1 sm:mt-0">
                                    <p class="font-bold text-slate-900 text-sm sm:text-base m-0">Rp {{ number_format($cat->price, 0, ',', '.') }}</p>
                                    <div class="flex items-center gap-2 bg-slate-50 rounded-full p-1 border border-slate-200">
                                        <button type="button" onclick="changeQty({{ $cat->id }}, -1)"
                                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white border border-slate-200 text-slate-500 flex items-center justify-center font-bold hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">−</button>
                                        <span id="qty-display-{{ $cat->id }}" class="w-6 sm:w-8 text-center font-bold text-slate-900 text-sm sm:text-base">0</span>
                                        <input type="hidden" name="tickets[{{ $cat->id }}][qty]" id="qty-{{ $cat->id }}" value="0">
                                        <button type="button" onclick="changeQty({{ $cat->id }}, 1)"
                                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white border border-slate-200 text-slate-500 flex items-center justify-center font-bold hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">+</button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 p-8 sm:p-10 text-center text-slate-400 text-sm sm:text-base">
                                Belum ada kategori tiket tersedia.
                            </div>
                        @endforelse
                    </div>

                    {{-- ── Informasi Pertunjukan ── --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-sm">
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-2 sm:mb-3">Informasi Pertunjukan</h3>
                        <p class="text-slate-500 text-sm leading-relaxed m-0">
                            {{ $concert->description ?: 'Rasakan pengalaman tata suara retro-futuristik terbaik bersama pionir synthwave. Pengalaman visual dan audio penuh dengan tata letak laser yang imersif.' }}
                        </p>
                    </div>
                </form>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="w-full md:w-[340px] shrink-0">
                <div class="sticky top-20 sm:top-24 flex flex-col gap-4 sm:gap-6">

                    {{-- Ringkasan --}}
                    <div class="bg-[#1a2744] rounded-2xl sm:rounded-[24px] p-5 sm:p-6 text-white shadow-xl shadow-[#1a2744]/20">
                        <div class="flex items-center gap-3 mb-4 sm:mb-5">
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs sm:text-sm font-bold shrink-0">2</div>
                            <h3 class="font-bold text-sm sm:text-base m-0">Ringkasan</h3>
                        </div>

                        <div class="mb-4 sm:mb-5">
                            <div class="flex justify-between items-center text-xs sm:text-sm text-white/50 pb-3 border-b border-white/10 mb-3">
                                <span>Pilihan</span>
                                <span id="summary-items-label" class="font-semibold">—</span>
                            </div>
                            <div id="selected-items-container" class="flex flex-col gap-2.5">
                                <!-- JS injected items -->
                            </div>
                        </div>

                        <div class="pt-4 border-t border-white/10 mb-5 sm:mb-6">
                            <p class="text-[10px] sm:text-xs text-white/40 mb-1 uppercase tracking-wider font-semibold">Total Tagihan</p>
                            <p id="summary-total" class="text-2xl sm:text-3xl font-black text-blue-400 m-0">Rp 0</p>
                        </div>

                        @auth
                            <button type="submit" form="ticket-form"
                                class="w-full py-3.5 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl text-sm sm:text-base flex items-center justify-center gap-2 transition-all shadow-lg shadow-blue-500/30 focus:outline-none focus:ring-4 focus:ring-blue-500/50">
                                Lanjut ke Keranjang
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                                class="w-full py-3.5 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl text-sm sm:text-base flex items-center justify-center gap-2 transition-all shadow-lg shadow-blue-500/30 text-center">
                                Login untuk Membeli
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <p class="text-[10px] sm:text-xs text-white/40 text-center mt-3 leading-relaxed">
                                Anda perlu login terlebih dahulu untuk membeli tiket.
                            </p>
                        @endauth
                    </div>

                    {{-- Denah Panggung & Area --}}
                    <div class="bg-white rounded-2xl sm:rounded-[24px] border border-slate-100 p-5 sm:p-6 shadow-sm text-center">
                        <h4 class="font-bold text-slate-900 text-sm sm:text-base mb-4">Denah Panggung & Area</h4>
                        <div class="aspect-square bg-slate-50 rounded-full border border-slate-200 mb-4 sm:mb-5 flex items-center justify-center relative overflow-hidden w-full max-w-[200px] sm:max-w-[240px] mx-auto">
                            <div class="w-24 h-24 sm:w-32 sm:h-32 border-[3px] border-blue-100 rounded-full flex items-center justify-center relative">
                                <div class="w-16 h-8 sm:w-20 sm:h-10 bg-blue-50 border-2 border-blue-200 rounded-t-full flex items-center justify-center absolute bottom-1/2 left-1/2 -translate-x-1/2">
                                    <span class="text-[8px] sm:text-[10px] font-bold text-blue-300 uppercase tracking-widest">Panggung</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-center gap-3 sm:gap-4">
                            <div class="flex items-center gap-1.5 text-[10px] sm:text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                <div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div> Dipilih
                            </div>
                            <div class="flex items-center gap-1.5 text-[10px] sm:text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-400"></div> Tersedia
                            </div>
                            <div class="flex items-center gap-1.5 text-[10px] sm:text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div> Habis
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ticketPrices = @json($concert->ticketCategories->pluck('price', 'id'));
    const ticketNames = @json($concert->ticketCategories->pluck('category_name', 'id'));

    function changeQty(id, delta) {
        const input = document.getElementById('qty-' + id);
        const display = document.getElementById('qty-display-' + id);
        const row = document.getElementById('row-' + id);

        let val = parseInt(input.value) + delta;
        if (val < 0) val = 0;
        if (val > 10) val = 10;

        input.value = val;
        display.innerText = val;

        if (val > 0) {
            row.classList.add('border-blue-500', 'bg-blue-50/50', 'shadow-md', 'shadow-blue-500/10');
            row.classList.remove('border-slate-100', 'bg-white', 'shadow-sm');
        } else {
            row.classList.remove('border-blue-500', 'bg-blue-50/50', 'shadow-md', 'shadow-blue-500/10');
            row.classList.add('border-slate-100', 'bg-white', 'shadow-sm');
        }

        updateSummary();
    }

    function updateSummary() {
        let total = 0;
        let selectedCount = 0;
        let summaryHtml = '';
        let lastItemLabel = '';

        Object.keys(ticketPrices).forEach(id => {
            const qty = parseInt(document.getElementById('qty-' + id).value);
            if (qty > 0) {
                const price = ticketPrices[id];
                const name = ticketNames[id];
                total += price * qty;
                selectedCount += qty;
                lastItemLabel = `${qty} × ${name}`;

                summaryHtml += `
                    <div class="flex justify-between items-center text-xs sm:text-sm">
                        <span class="text-white/60">${qty} × ${name}</span>
                        <span class="font-semibold text-white">Rp ${(price * qty).toLocaleString('id-ID')}</span>
                    </div>
                `;
            }
        });

        document.getElementById('selected-items-container').innerHTML = summaryHtml;
        document.getElementById('summary-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('summary-items-label').innerText = selectedCount > 0 ? lastItemLabel : '—';
    }
</script>
</x-layout>
