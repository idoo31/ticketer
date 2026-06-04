<x-layout>
<div style="background:#f8fafc; min-height:100vh; padding:24px 0;">
    <div style="max-width:1100px; margin:0 auto; padding:0 24px;">

        {{-- ── Stepper ── --}}
        <div style="display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:50%; background:#3b82f6; color:#fff; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; box-shadow:0 2px 8px rgba(59,130,246,0.35);">1</div>
                <span style="font-weight:700; color:#0f172a; font-size:13px;">Keranjang</span>
            </div>
            <div style="height:2px; width:56px; background:#cbd5e1;"></div>
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:50%; border:2px solid #e2e8f0; color:#cbd5e1; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700;">2</div>
                <span style="font-weight:500; color:#cbd5e1; font-size:13px;">Pembayaran</span>
            </div>
            <div style="height:2px; width:56px; background:#e2e8f0;"></div>
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:50%; border:2px solid #e2e8f0; color:#cbd5e1; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700;">3</div>
                <span style="font-weight:500; color:#cbd5e1; font-size:13px;">Selesai</span>
            </div>
        </div>

        {{-- ── Two-Column Layout ── --}}
        <div style="display:flex; gap:20px; align-items:flex-start;">

            {{-- LEFT: Tiket Anda --}}
            <div style="flex:1; min-width:0;">
                <h2 style="font-size:17px; font-weight:800; color:#0f172a; margin:0 0 16px;">Tiket Anda</h2>

                <div style="display:flex; flex-direction:column; gap:12px;">
                    @foreach($lineItems as $item)
                        <div style="background:#fff; border-radius:14px; border:1px solid #e2e8f0; padding:16px; box-shadow:0 1px 4px rgba(0,0,0,0.05); display:flex; align-items:center; gap:16px;">
                            {{-- Image --}}
                            <div style="width:72px; height:72px; background:#f1f5f9; border-radius:12px; flex-shrink:0; overflow:hidden;">
                                @if($concert->banner_url)
                                    <img src="{{ Storage::url($concert->banner_url) }}" alt="{{ $concert->title }}" style="width:100%; height:100%; object-fit:cover; display:block;">
                                @else
                                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                                        <svg style="width:28px; height:28px;" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 012 2v3a2 2 0 000 4v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3a2 2 0 000-4V7a2 2 0 012-2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div style="flex:1; min-width:0;">
                                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                                    <div style="min-width:0; flex:1;">
                                        <span style="display:inline-block; padding:2px 8px; border-radius:100px; background:#eff6ff; color:#3b82f6; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:4px;">
                                            {{ $item['category']->category_name }}
                                        </span>
                                        <h3 style="font-weight:700; color:#0f172a; font-size:14px; margin:0 0 2px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $concert->title }}</h3>
                                        <p style="font-size:12px; color:#94a3b8; margin:0;">
                                            {{ $concert->event_date->translatedFormat('D, d M Y') }} · {{ $concert->city }}
                                        </p>
                                    </div>
                                    <button type="button" style="background:none; border:none; cursor:pointer; color:#cbd5e1; margin-left:12px; flex-shrink:0; padding:2px;"
                                        onmouseover="this.style.color='#f87171'" onmouseout="this.style.color='#cbd5e1'">
                                        <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                                <div style="display:flex; justify-content:space-between; align-items:center; padding-top:10px; border-top:1px solid #f8fafc;">
                                    <div style="display:flex; align-items:center; gap:6px; background:#f8fafc; border-radius:100px; padding:3px; border:1px solid #e2e8f0;">
                                        <button type="button" style="width:26px; height:26px; border-radius:50%; background:#fff; border:1px solid #e2e8f0; color:#64748b; display:flex; align-items:center; justify-content:center; font-weight:700; cursor:pointer; font-size:14px; line-height:1;"
                                            onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">−</button>
                                        <span style="width:20px; text-align:center; font-weight:700; color:#0f172a; font-size:14px;">{{ $item['qty'] }}</span>
                                        <button type="button" style="width:26px; height:26px; border-radius:50%; background:#fff; border:1px solid #e2e8f0; color:#64748b; display:flex; align-items:center; justify-content:center; font-weight:700; cursor:pointer; font-size:14px; line-height:1;"
                                            onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">+</button>
                                    </div>
                                    <p style="font-weight:800; color:#0f172a; font-size:16px; margin:0;">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT: Ringkasan Pesanan --}}
            <div style="width:300px; flex-shrink:0;">
                <div style="background:#1a2744; border-radius:18px; padding:20px; color:#fff; position:sticky; top:24px; box-shadow:0 4px 20px rgba(26,39,68,0.25);">
                    <h3 style="font-weight:800; font-size:15px; margin:0 0 16px;">Ringkasan Pesanan</h3>

                    <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:16px;">
                        <div style="display:flex; justify-content:space-between; font-size:13px;">
                            <span style="color:rgba(255,255,255,0.5);">Subtotal ({{ collect($lineItems)->sum('qty') }} tiket)</span>
                            <span style="font-weight:600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:13px;">
                            <span style="color:rgba(255,255,255,0.5);">Biaya Layanan (5%)</span>
                            <span style="font-weight:600;">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:13px;">
                            <span style="color:rgba(255,255,255,0.5);">Pajak (10%)</span>
                            <span style="font-weight:600;">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div style="border-top:1px solid rgba(255,255,255,0.1); padding-top:14px; margin-bottom:16px;">
                        <p style="font-size:11px; color:rgba(255,255,255,0.4); margin:0 0 4px; text-transform:uppercase; letter-spacing:0.05em;">Total Tagihan</p>
                        <p style="font-size:26px; font-weight:900; color:#60a5fa; margin:0;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
                    </div>

                    <a href="{{ route('checkout.payment', $concert) }}"
                        style="display:flex; align-items:center; justify-content:center; gap:6px; width:100%; padding:12px; background:#3b82f6; color:#fff; font-weight:700; border-radius:10px; font-size:13px; text-decoration:none; box-shadow:0 4px 12px rgba(59,130,246,0.35); transition:background 0.2s;"
                        onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                        Lanjut Pembayaran
                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
</x-layout>
