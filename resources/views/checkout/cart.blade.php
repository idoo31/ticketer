<x-layout>
<div class="bg-slate-50 min-h-screen py-6 sm:py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── Stepper ── --}}
        <div class="flex items-center justify-center gap-2 sm:gap-3 mb-6 sm:mb-8 flex-wrap">
            <div class="flex items-center gap-1.5 sm:gap-2">
                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs sm:text-sm font-bold shadow-md shadow-blue-500/30">1</div>
                <span class="font-bold text-slate-900 text-xs sm:text-sm">Keranjang</span>
            </div>
            <div class="h-0.5 w-6 sm:w-10 bg-slate-300 hidden sm:block"></div>
            <div class="flex items-center gap-1.5 sm:gap-2">
                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full border-2 border-slate-200 text-slate-300 flex items-center justify-center text-xs sm:text-sm font-bold">2</div>
                <span class="font-medium text-slate-300 text-xs sm:text-sm">Pembayaran</span>
            </div>
            <div class="h-0.5 w-6 sm:w-10 bg-slate-200 hidden sm:block"></div>
            <div class="flex items-center gap-1.5 sm:gap-2">
                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full border-2 border-slate-200 text-slate-300 flex items-center justify-center text-xs sm:text-sm font-bold">3</div>
                <span class="font-medium text-slate-300 text-xs sm:text-sm">Selesai</span>
            </div>
        </div>

        {{-- ── Two-Column Layout ── --}}
        <div class="flex flex-col md:flex-row gap-6 items-start">

            {{-- LEFT: Tiket Anda --}}
            <div class="flex-1 min-w-0 w-full">
                <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 mb-4">Tiket Anda</h2>

                <div class="flex flex-col gap-3 sm:gap-4">
                    @foreach($lineItems as $item)
                        <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-sm flex flex-col sm:flex-row sm:items-center gap-4 relative overflow-hidden">
                            {{-- Image --}}
                            <div class="w-full sm:w-20 h-32 sm:h-20 bg-slate-100 rounded-xl flex-shrink-0 overflow-hidden relative border border-slate-200 sm:border-none">
                                @if($concert->banner_url)
                                    <img src="{{ Storage::url($concert->banner_url) }}" alt="{{ $concert->title }}" class="absolute inset-0 w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 012 2v3a2 2 0 000 4v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3a2 2 0 000-4V7a2 2 0 012-2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0 flex flex-col justify-center">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="min-w-0 flex-1">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-500 text-[10px] font-bold uppercase tracking-wider mb-1.5">
                                            {{ $item['category']->category_name }}
                                        </span>
                                        <h3 class="font-bold text-slate-900 text-sm sm:text-base m-0 truncate pr-2">{{ $concert->title }}</h3>
                                        <p class="text-xs text-slate-400 mt-0.5 m-0">
                                            {{ $concert->event_date->translatedFormat('D, d M Y') }} &bull; {{ $concert->city }}
                                        </p>
                                    </div>
                                    <button type="button" class="shrink-0 ml-2 text-slate-300 hover:text-red-400 focus:outline-none p-1 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="border-t border-dashed border-slate-100 my-3 sm:hidden"></div>
                                
                                <div class="flex justify-between items-center sm:pt-2 sm:border-t sm:border-slate-50 mt-auto sm:mt-1">
                                    <div class="flex items-center gap-2 bg-slate-50 rounded-full p-1 border border-slate-200">
                                        <button type="button" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-white border border-slate-200 text-slate-500 flex items-center justify-center font-bold hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm leading-none pb-0.5">−</button>
                                        
                                        <span class="w-6 sm:w-8 text-center font-bold text-slate-900 text-sm sm:text-base">{{ $item['qty'] }}</span>
                                        
                                        <button type="button" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-white border border-slate-200 text-slate-500 flex items-center justify-center font-bold hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm leading-none pb-0.5">+</button>
                                    </div>
                                    <p class="font-extrabold text-slate-900 text-sm sm:text-base m-0">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT: Ringkasan Pesanan --}}
            <div class="w-full md:w-[320px] shrink-0">
                <div class="bg-[#1a2744] rounded-[24px] p-5 sm:p-6 text-white sticky top-20 sm:top-24 shadow-xl shadow-[#1a2744]/20">
                    <h3 class="font-extrabold text-sm sm:text-base mb-4 sm:mb-5">Ringkasan Pesanan</h3>

                    <div class="flex flex-col gap-2.5 sm:gap-3 mb-4 sm:mb-5">
                        <div class="flex justify-between items-center text-xs sm:text-sm">
                            <span class="text-white/50">Subtotal ({{ collect($lineItems)->sum('qty') }} tiket)</span>
                            <span class="font-semibold text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs sm:text-sm">
                            <span class="text-white/50">Biaya Layanan (5%)</span>
                            <span class="font-semibold text-white">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs sm:text-sm">
                            <span class="text-white/50">Pajak (10%)</span>
                            <span class="font-semibold text-white">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white/10 mb-5 sm:mb-6">
                        <p class="text-[10px] sm:text-xs text-white/40 mb-1 uppercase tracking-wider font-semibold">Total Tagihan</p>
                        <p class="text-2xl sm:text-3xl font-black text-blue-400 m-0">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
                    </div>

                    <a href="{{ route('checkout.payment', $concert) }}"
                        class="flex items-center justify-center gap-2 w-full py-3.5 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl text-sm sm:text-base transition-all shadow-lg shadow-blue-500/30 focus:outline-none focus:ring-4 focus:ring-blue-500/50">
                        Lanjut Pembayaran
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
</x-layout>
