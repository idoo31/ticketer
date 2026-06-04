<x-layout>
<div style="background:#f8fafc; min-height:100vh;">

    {{-- ── Breadcrumb ── --}}
    <div style="background:#fff; border-bottom:1px solid #f1f5f9;">
        <div style="max-width:1100px; margin:0 auto; padding:10px 24px;">
            <nav style="display:flex; align-items:center; gap:6px; font-size:12px; color:#94a3b8;">
                <a href="{{ route('home') }}" style="color:#94a3b8; text-decoration:none;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#94a3b8'">Beranda</a>
                <span style="color:#cbd5e1;">›</span>
                <a href="/konser" style="color:#94a3b8; text-decoration:none;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#94a3b8'">Konser</a>
                <span style="color:#cbd5e1;">›</span>
                <span style="color:#475569; font-weight:500;">{{ $concert->title }}</span>
            </nav>
        </div>
    </div>

    <div style="max-width:1100px; margin:0 auto; padding:24px;">

        {{-- ── Header ── --}}
        <div style="margin-bottom:20px;">
            <h1 style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 10px;">{{ $concert->title }}</h1>
            @if($concert->artists->isNotEmpty())
                <div style="display:flex; flex-wrap:wrap; align-items:center; gap:10px; margin-top:8px;">
                    @foreach($concert->artists as $artist)
                        <div style="display:flex; align-items:center; gap:8px; background:#eff6ff; border-radius:100px; padding:5px 14px 5px 5px; border:1px solid #dbeafe;">
                            @if($artist->image_url)
                                <img src="{{ Storage::url($artist->image_url) }}" alt="{{ $artist->name }}"
                                     style="width:30px; height:30px; border-radius:50%; object-fit:cover; border:2px solid #bfdbfe; flex-shrink:0;">
                            @else
                                <div style="width:30px; height:30px; border-radius:50%; background:#3b82f6; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:11px; font-weight:700; color:#fff;">
                                    {{ strtoupper(substr($artist->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p style="font-weight:700; color:#1e40af; font-size:12px; margin:0; line-height:1.2;">{{ $artist->name }}</p>
                                @if($artist->genre)
                                    <p style="font-size:10px; color:#60a5fa; margin:0;">{{ $artist->genre }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ── Two-Column Layout ── --}}
        <div style="display:flex; gap:20px; align-items:flex-start;">

            {{-- LEFT COLUMN --}}
            <div style="flex:1; min-width:0;">

                {{-- Concert Info Card --}}
                <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; display:flex; margin-bottom:20px; box-shadow:0 1px 4px rgba(0,0,0,0.06);">
                    {{-- Banner --}}
                    <div style="width:200px; min-height:160px; background:#f1f5f9; flex-shrink:0; overflow:hidden;">
                        @if($concert->banner_url)
                            <img src="{{ Storage::url($concert->banner_url) }}" alt="{{ $concert->title }}" style="width:100%; height:100%; object-fit:cover; display:block;">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; min-height:160px;">
                                <svg style="width:40px; height:40px; color:#cbd5e1;" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 012 2v3a2 2 0 000 4v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3a2 2 0 000-4V7a2 2 0 012-2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    {{-- Date & Venue --}}
                    <div style="flex:1; padding:20px 24px; display:flex; flex-direction:column; justify-content:center; gap:16px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:36px; height:36px; border-radius:10px; background:#eff6ff; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <svg style="width:18px; height:18px;" fill="none" stroke="#3b82f6" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-weight:700; color:#0f172a; font-size:13px; margin:0 0 2px;">{{ $concert->event_date->translatedFormat('l, d F Y') }}</p>
                                <p style="font-size:12px; color:#94a3b8; margin:0;">{{ $concert->event_time ?? '19.00' }} WIB</p>
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:36px; height:36px; border-radius:10px; background:#ecfeff; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <svg style="width:18px; height:18px;" fill="#06b6d4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-weight:700; color:#0f172a; font-size:13px; margin:0 0 2px;">{{ $concert->venue_name }}</p>
                                <p style="font-size:12px; color:#94a3b8; margin:0;">{{ $concert->city }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Section: Pilih Kategori Tiket ── --}}
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:14px;">
                    <div style="width:26px; height:26px; border-radius:50%; background:#3b82f6; color:#fff; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0; box-shadow:0 2px 6px rgba(59,130,246,0.35);">1</div>
                    <h2 style="font-size:15px; font-weight:800; color:#0f172a; margin:0;">Pilih Kategori Tiket</h2>
                </div>

                <form method="POST" action="{{ route('checkout.cart.save', $concert) }}" id="ticket-form">
                    @csrf

                    @if($errors->any())
                        <div style="margin-bottom:14px; background:#fef2f2; border:1px solid #fecaca; color:#dc2626; border-radius:10px; padding:10px 14px; font-size:13px; display:flex; align-items:center; gap:8px;">
                            <svg style="width:16px; height:16px; flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:18px;">
                        @forelse($concert->ticketCategories as $cat)
                            <div id="row-{{ $cat->id }}" style="background:#fff; border-radius:12px; border:2px solid #f1f5f9; padding:14px 16px; display:flex; align-items:center; justify-content:space-between; transition:all 0.2s; box-shadow:0 1px 3px rgba(0,0,0,0.04);"
                                onmouseover="if(!this.classList.contains('selected')){this.style.borderColor='#bfdbfe';this.style.boxShadow='0 2px 8px rgba(59,130,246,0.1)';}"
                                onmouseout="if(!this.classList.contains('selected')){this.style.borderColor='#f1f5f9';this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)';}">
                                <div>
                                    <p style="font-weight:700; color:#0f172a; font-size:14px; margin:0 0 3px;">{{ $cat->category_name }}</p>
                                    <p style="font-size:12px; color:#94a3b8; margin:0;">{{ $cat->available_quota }} tiket tersedia</p>
                                </div>
                                <div style="display:flex; align-items:center; gap:16px;">
                                    <p style="font-weight:700; color:#0f172a; font-size:14px; margin:0;">Rp {{ number_format($cat->price, 0, ',', '.') }}</p>
                                    <div style="display:flex; align-items:center; gap:6px; background:#f8fafc; border-radius:100px; padding:3px; border:1px solid #e2e8f0;">
                                        <button type="button" onclick="changeQty({{ $cat->id }}, -1)"
                                            style="width:28px; height:28px; border-radius:50%; background:#fff; border:1px solid #e2e8f0; color:#64748b; display:flex; align-items:center; justify-content:center; font-weight:700; cursor:pointer; font-size:14px; line-height:1; transition:all 0.15s;"
                                            onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">−</button>
                                        <span id="qty-display-{{ $cat->id }}" style="width:22px; text-align:center; font-weight:700; color:#0f172a; font-size:14px;">0</span>
                                        <input type="hidden" name="tickets[{{ $cat->id }}][qty]" id="qty-{{ $cat->id }}" value="0">
                                        <button type="button" onclick="changeQty({{ $cat->id }}, 1)"
                                            style="width:28px; height:28px; border-radius:50%; background:#fff; border:1px solid #e2e8f0; color:#64748b; display:flex; align-items:center; justify-content:center; font-weight:700; cursor:pointer; font-size:14px; line-height:1; transition:all 0.15s;"
                                            onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">+</button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div style="background:#f8fafc; border-radius:12px; border:2px dashed #e2e8f0; padding:40px; text-align:center; color:#94a3b8; font-size:14px;">
                                Belum ada kategori tiket tersedia.
                            </div>
                        @endforelse
                    </div>

                    {{-- ── Informasi Pertunjukan ── --}}
                    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:18px 20px; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
                        <h3 style="font-size:14px; font-weight:700; color:#0f172a; margin:0 0 8px;">Informasi Pertunjukan</h3>
                        <p style="color:#64748b; font-size:13px; line-height:1.65; margin:0;">
                            {{ $concert->description ?: 'Rasakan pengalaman tata suara retro-futuristik terbaik bersama pionir synthwave. Pengalaman visual dan audio penuh dengan tata letak laser yang imersif.' }}
                        </p>
                    </div>
                </form>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div style="width:300px; flex-shrink:0;">
                <div style="position:sticky; top:24px; display:flex; flex-direction:column; gap:16px;">

                    {{-- Ringkasan --}}
                    <div style="background:#1a2744; border-radius:18px; padding:20px; color:#fff; box-shadow:0 4px 20px rgba(26,39,68,0.25);">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px;">
                            <div style="width:24px; height:24px; border-radius:50%; background:#3b82f6; color:#fff; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700;">2</div>
                            <h3 style="font-weight:700; font-size:14px; margin:0;">Ringkasan</h3>
                        </div>

                        <div style="margin-bottom:16px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; color:rgba(255,255,255,0.45); padding-bottom:12px; border-bottom:1px solid rgba(255,255,255,0.1); margin-bottom:12px;">
                                <span>Pilihan</span>
                                <span id="summary-items-label" style="font-weight:600;">—</span>
                            </div>
                            <div id="selected-items-container" style="display:flex; flex-direction:column; gap:8px;">
                                <!-- JS injected items -->
                            </div>
                        </div>

                        <div style="padding-top:14px; border-top:1px solid rgba(255,255,255,0.1); margin-bottom:16px;">
                            <p style="font-size:11px; color:rgba(255,255,255,0.4); margin:0 0 4px; text-transform:uppercase; letter-spacing:0.05em;">Total Tagihan</p>
                            <p id="summary-total" style="font-size:26px; font-weight:900; color:#60a5fa; margin:0;">Rp 0</p>
                        </div>

                        @auth
                            <button type="submit" form="ticket-form"
                                style="width:100%; padding:12px; background:#3b82f6; border:none; color:#fff; font-weight:700; border-radius:10px; font-size:13px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; transition:background 0.2s; box-shadow:0 4px 12px rgba(59,130,246,0.35);"
                                onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                                Lanjut ke Keranjang
                                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                                style="width:100%; padding:12px; background:#3b82f6; color:#fff; font-weight:700; border-radius:10px; font-size:13px; display:flex; align-items:center; justify-content:center; gap:6px; text-decoration:none; transition:background 0.2s; box-shadow:0 4px 12px rgba(59,130,246,0.35);"
                                onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                                Login untuk Membeli Tiket
                                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <p style="font-size:11px; color:rgba(255,255,255,0.3); text-align:center; margin-top:10px; line-height:1.5;">
                                Anda perlu login terlebih dahulu untuk membeli tiket.
                            </p>
                        @endauth
                    </div>

                    {{-- Denah Panggung & Area --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #f1f5f9; padding:18px; box-shadow:0 1px 4px rgba(0,0,0,0.05); text-align:center;">
                        <h4 style="font-weight:700; color:#0f172a; font-size:13px; margin:0 0 14px;">Denah Panggung & Area</h4>
                        <div style="aspect-ratio:1/1; background:#f8fafc; border-radius:50%; border:1px solid #e2e8f0; margin-bottom:14px; display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden; max-width:220px; margin-left:auto; margin-right:auto;">
                            <div style="width:110px; height:110px; border:3px solid #dbeafe; border-radius:50%; display:flex; align-items:center; justify-content:center; position:relative;">
                                <div style="width:70px; height:35px; background:#eff6ff; border:2px solid #bfdbfe; border-radius:35px 35px 0 0; display:flex; align-items:center; justify-content:center; position:absolute; bottom:50%; left:50%; transform:translateX(-50%);">
                                    <span style="font-size:8px; font-weight:700; color:#93c5fd; text-transform:uppercase; letter-spacing:0.08em;">Panggung</span>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex; justify-content:center; gap:14px;">
                            <div style="display:flex; align-items:center; gap:5px; font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em;">
                                <div style="width:8px; height:8px; border-radius:50%; background:#3b82f6;"></div> Dipilih
                            </div>
                            <div style="display:flex; align-items:center; gap:5px; font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em;">
                                <div style="width:8px; height:8px; border-radius:50%; background:#94a3b8;"></div> Tersedia
                            </div>
                            <div style="display:flex; align-items:center; gap:5px; font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em;">
                                <div style="width:8px; height:8px; border-radius:50%; background:#f87171;"></div> Habis
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
            row.style.borderColor = '#3b82f6';
            row.style.background = 'rgba(239,246,255,0.5)';
            row.style.boxShadow = '0 2px 8px rgba(59,130,246,0.12)';
        } else {
            row.style.borderColor = '#f1f5f9';
            row.style.background = '#fff';
            row.style.boxShadow = '0 1px 3px rgba(0,0,0,0.04)';
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
                    <div style="display:flex; justify-content:space-between; align-items:center; font-size:12px;">
                        <span style="color:rgba(255,255,255,0.55);">${qty} × ${name}</span>
                        <span style="font-weight:600; color:#fff;">Rp ${(price * qty).toLocaleString('id-ID')}</span>
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
