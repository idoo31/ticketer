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
                            <div id="row-{{ $cat->id }}" class="category-row bg-white rounded-xl sm:rounded-2xl border-2 border-slate-100 p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all duration-300 hover:border-blue-200 hover:shadow-md hover:shadow-blue-500/5 shadow-sm">
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
                    <div class="bg-white rounded-2xl sm:rounded-[24px] border border-slate-100 p-5 sm:p-6 shadow-sm text-center relative overflow-hidden">
                        <h4 class="font-bold text-slate-900 text-sm sm:text-base mb-4">Denah Panggung & Area</h4>
                        
                        @php
                            // Mengelompokkan kategori berdasarkan harga (descending) untuk dipetakan ke zona
                            $sortedCategories = $concert->ticketCategories->sortByDesc('price')->values();
                            $catCount = $sortedCategories->count();
                            
                            $zoneMapping = [];
                            for ($i = 0; $i < 4; $i++) {
                                $zoneMapping[$i] = $i < $catCount ? $sortedCategories[$i] : $sortedCategories->last();
                            }
                        @endphp

                        <div class="w-full relative mx-auto my-4 sm:my-6 transition-transform hover:scale-[1.02] duration-300 select-none">
                            <svg viewBox="-30 -10 460 380" class="w-full h-auto drop-shadow-md font-sans">
                                <!-- STAGE -->
                                <rect x="150" y="0" width="100" height="40" fill="#0f172a" rx="6" />
                                <text x="200" y="25" fill="#ffffff" font-size="14" font-weight="900" text-anchor="middle" letter-spacing="2">STAGE</text>

                                <!-- FOH -->
                                <rect x="180" y="100" width="40" height="40" fill="#0f172a" rx="4" />
                                <text x="200" y="125" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">FOH</text>

                                @if($zoneMapping[0])
                                <!-- FESTIVAL (Center) -->
                                <g class="map-zone cursor-pointer transition-all duration-300 hover:brightness-110" 
                                   onclick="selectZone({{ $zoneMapping[0]->id }}, this)">
                                    <path d="M 140 50 L 260 50 L 260 170 C 260 210, 140 210, 140 170 Z" 
                                          fill="#86efac" stroke="#ffffff" stroke-width="4" id="zone-path-{{ $zoneMapping[0]->id }}-0" />
                                    <text x="200" y="170" fill="#14532d" font-size="14" font-weight="900" text-anchor="middle" class="pointer-events-none">{{ strtoupper($zoneMapping[0]->category_name) }}</text>
                                </g>
                                @endif

                                @if($zoneMapping[1])
                                <!-- CAT 1A (Left Wing) -->
                                <g class="map-zone cursor-pointer transition-all duration-300 hover:brightness-110" 
                                   onclick="selectZone({{ $zoneMapping[1]->id }}, this)">
                                    <path d="M 70 70 L 130 50 L 130 170 C 130 210, 90 220, 50 190 Z" 
                                          fill="#d8b4fe" stroke="#ffffff" stroke-width="4" id="zone-path-{{ $zoneMapping[1]->id }}-1a" />
                                    <text x="90" y="145" fill="#581c87" font-size="12" font-weight="800" text-anchor="middle" class="pointer-events-none">{{ strtoupper($zoneMapping[1]->category_name) }}</text>
                                </g>

                                <!-- CAT 1B (Right Wing) -->
                                <g class="map-zone cursor-pointer transition-all duration-300 hover:brightness-110" 
                                   onclick="selectZone({{ $zoneMapping[1]->id }}, this)">
                                    <path d="M 330 70 L 270 50 L 270 170 C 270 210, 310 220, 350 190 Z" 
                                          fill="#d8b4fe" stroke="#ffffff" stroke-width="4" id="zone-path-{{ $zoneMapping[1]->id }}-1b" />
                                    <text x="310" y="145" fill="#581c87" font-size="12" font-weight="800" text-anchor="middle" class="pointer-events-none">{{ strtoupper($zoneMapping[1]->category_name) }}</text>
                                </g>
                                @endif

                                @if($zoneMapping[2])
                                <!-- CAT 2A (Bottom Left) -->
                                <g class="map-zone cursor-pointer transition-all duration-300 hover:brightness-110" 
                                   onclick="selectZone({{ $zoneMapping[2]->id }}, this)">
                                    <path d="M 50 195 C 90 235, 150 245, 195 220 L 195 270 C 140 295, 60 280, 20 225 Z" 
                                          fill="#fcd34d" stroke="#ffffff" stroke-width="4" id="zone-path-{{ $zoneMapping[2]->id }}-2a" />
                                    <text x="110" y="255" fill="#78350f" font-size="12" font-weight="800" text-anchor="middle" class="pointer-events-none">{{ strtoupper($zoneMapping[2]->category_name) }}</text>
                                </g>

                                <!-- CAT 2B (Bottom Right) -->
                                <g class="map-zone cursor-pointer transition-all duration-300 hover:brightness-110" 
                                   onclick="selectZone({{ $zoneMapping[2]->id }}, this)">
                                    <path d="M 350 195 C 310 235, 250 245, 205 220 L 205 270 C 260 295, 340 280, 380 225 Z" 
                                          fill="#fcd34d" stroke="#ffffff" stroke-width="4" id="zone-path-{{ $zoneMapping[2]->id }}-2b" />
                                    <text x="290" y="255" fill="#78350f" font-size="12" font-weight="800" text-anchor="middle" class="pointer-events-none">{{ strtoupper($zoneMapping[2]->category_name) }}</text>
                                </g>
                                @endif

                                @if($zoneMapping[3])
                                <!-- CAT 3A (Outer Bottom Left) -->
                                <g class="map-zone cursor-pointer transition-all duration-300 hover:brightness-110" 
                                   onclick="selectZone({{ $zoneMapping[3]->id }}, this)">
                                    <path d="M 15 230 C 60 290, 145 305, 195 275 L 195 325 C 130 355, 30 340, -15 260 Z" 
                                          fill="#fca5a5" stroke="#ffffff" stroke-width="4" id="zone-path-{{ $zoneMapping[3]->id }}-3a" />
                                    <text x="100" y="310" fill="#7f1d1d" font-size="12" font-weight="800" text-anchor="middle" class="pointer-events-none">{{ strtoupper($zoneMapping[3]->category_name) }}</text>
                                </g>

                                <!-- CAT 3B (Outer Bottom Right) -->
                                <g class="map-zone cursor-pointer transition-all duration-300 hover:brightness-110" 
                                   onclick="selectZone({{ $zoneMapping[3]->id }}, this)">
                                    <path d="M 385 230 C 340 290, 255 305, 205 275 L 205 325 C 270 355, 370 340, 415 260 Z" 
                                          fill="#fca5a5" stroke="#ffffff" stroke-width="4" id="zone-path-{{ $zoneMapping[3]->id }}-3b" />
                                    <text x="300" y="310" fill="#7f1d1d" font-size="12" font-weight="800" text-anchor="middle" class="pointer-events-none">{{ strtoupper($zoneMapping[3]->category_name) }}</text>
                                </g>
                                @endif
                            </svg>
                        </div>

                        <div class="flex flex-col gap-2 mt-2">
                            <p class="text-xs text-slate-400 mb-2">Klik area pada denah untuk memilih tiket.</p>
                            <div class="flex flex-wrap justify-center gap-3 sm:gap-4">
                                <div class="flex items-center gap-1.5 text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500 ring-2 ring-blue-200"></div> Dipilih
                                </div>
                                <div class="flex items-center gap-1.5 text-[10px] sm:text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    <div class="w-2.5 h-2.5 rounded-full bg-slate-300"></div> Tersedia
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
</div>

<script>
    const ticketPrices = @json($concert->ticketCategories->pluck('price', 'id'));
    const ticketNames = @json($concert->ticketCategories->pluck('category_name', 'id'));

    function changeQty(id, delta) {
        const input = document.getElementById('qty-' + id);
        const display = document.getElementById('qty-display-' + id);
        const row = document.getElementById('row-' + id);

        if (!input) return; // Prevent error if category not found

        let val = parseInt(input.value) + delta;
        if (val < 0) val = 0;
        if (val > 10) val = 10;

        input.value = val;
        display.innerText = val;

        // Highlight Row
        if (val > 0) {
            row.classList.add('border-blue-500', 'bg-blue-50/50', 'shadow-md', 'shadow-blue-500/10');
            row.classList.remove('border-slate-100', 'bg-white', 'shadow-sm');
        } else {
            row.classList.remove('border-blue-500', 'bg-blue-50/50', 'shadow-md', 'shadow-blue-500/10');
            row.classList.add('border-slate-100', 'bg-white', 'shadow-sm');
        }

        updateSummary();
        updateMapSelection();
    }

    function selectZone(id, element) {
        // Highlight logic in list
        const row = document.getElementById('row-' + id);
        if (row) {
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Highlight effect on row
            row.classList.add('ring-4', 'ring-blue-500/30');
            setTimeout(() => {
                row.classList.remove('ring-4', 'ring-blue-500/30');
            }, 1000);
            
            // Add 1 ticket
            changeQty(id, 1);
        }
    }

    function updateMapSelection() {
        // Reset all map zones to their default appearance
        document.querySelectorAll('.map-zone path').forEach(path => {
            path.setAttribute('stroke', '#ffffff');
            path.setAttribute('stroke-width', '4');
        });

        // Highlight selected zones on the map
        Object.keys(ticketPrices).forEach(id => {
            const qty = parseInt(document.getElementById('qty-' + id).value);
            if (qty > 0) {
                // Find paths for this category ID
                const paths = document.querySelectorAll(`path[id^="zone-path-${id}"]`);
                paths.forEach(path => {
                    path.setAttribute('stroke', '#3b82f6'); // blue-500
                    path.setAttribute('stroke-width', '8');
                });
            }
        });
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
