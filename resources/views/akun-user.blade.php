<x-layout>
    {{-- Flash alerts --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-6 right-6 z-50 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3.5 rounded-xl text-sm font-semibold shadow-lg">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-6 right-6 z-50 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl text-sm font-semibold shadow-lg">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif
    <div class="bg-gray-50 min-h-screen">

        {{-- ── Header / Profile ── --}}
        <div class="pt-8 md:pt-12 pb-8 md:pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6 text-center sm:text-left">
                    {{-- Avatar --}}
                    <div class="w-24 h-24 sm:w-32 sm:h-32 bg-white border-2 border-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>

                    {{-- Info --}}
                    <div class="flex flex-col items-center sm:items-start">
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-1">{{ $user->name }}</h1>
                        <p class="text-xs sm:text-sm text-gray-500 font-semibold">
                            {{ $user->email }}
                            <span class="hidden sm:inline">&bull;</span>
                            <span class="block sm:inline mt-1 sm:mt-0">Bergabung Sejak {{ $user->created_at->translatedFormat('Y') }}</span>
                        </p>
                        <span class="inline-block mt-3 px-3 py-1 text-xs font-semibold rounded-full
                            {{ $user->isAdmin() ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $user->isAdmin() ? 'Admin' : 'Customer' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Main Content ── --}}
        <div class="pb-16 md:pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row gap-6 md:gap-8">

                    {{-- ── Sidebar ── --}}
                    <div class="w-full md:w-72 flex-shrink-0">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sticky top-24">
                            <nav class="flex flex-row md:flex-col gap-2 overflow-x-auto md:overflow-x-visible pb-2 md:pb-0 scrollbar-hide">
                                <a href="#tiket"
                                    class="flex-shrink-0 flex items-center justify-center md:justify-start gap-2 md:gap-3 px-4 py-3 md:py-4 bg-blue-600 text-white rounded-xl font-semibold shadow-sm w-1/2 md:w-full text-sm md:text-base">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                    Dompet Tiket
                                </a>
                                <a href="#riwayat"
                                    class="flex-shrink-0 flex items-center justify-center md:justify-start gap-2 md:gap-3 px-4 py-3 md:py-4 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-semibold transition-colors w-1/2 md:w-full text-sm md:text-base border border-gray-100 md:border-transparent">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Riwayat Pesanan
                                </a>
                            </nav>

                            {{-- Stats --}}
                            <div class="mt-6 border-t border-gray-100 pt-4 space-y-3">
                                <div class="flex justify-between items-center px-2">
                                    <span class="text-xs sm:text-sm text-gray-500">Total Transaksi</span>
                                    <span class="text-xs sm:text-sm font-bold text-gray-900">{{ $transactions->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center px-2">
                                    <span class="text-xs sm:text-sm text-gray-500">Total Tiket</span>
                                    <span class="text-xs sm:text-sm font-bold text-gray-900">
                                        {{ $transactions->flatMap->details->sum('quantity') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center px-2">
                                    <span class="text-xs sm:text-sm text-gray-500">Total Pengeluaran</span>
                                    <span class="text-xs sm:text-sm font-bold text-blue-600">
                                        Rp {{ number_format($transactions->sum('grand_total'), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Main Area ── --}}
                    <div x-data="{
                        cancelModal: false,
                        cancelBlockedModal: false,
                        cancelAction: '',
                        cancelTitle: '',
                        openCancelModal(action, title, cancellable) {
                            this.cancelAction = action;
                            this.cancelTitle = title;
                            if (cancellable) {
                                this.cancelModal = true;
                            } else {
                                this.cancelBlockedModal = true;
                            }
                        }
                    }" class="flex-1 space-y-8 md:space-y-12">

                        {{-- E-Ticket Aktif --}}
                        <div id="tiket" class="scroll-mt-24">
                            <div class="mb-4 sm:mb-6">
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">E-Ticket Aktif Anda</h2>
                                <p class="text-gray-500 text-xs sm:text-sm">Tunjukkan kode QR atau download PDF tiket untuk masuk ke area acara.</p>
                            </div>

                            @php
                                $activeTickets = $transactions->where('status', 'paid');
                            @endphp

                            @if($activeTickets->count() > 0)
                                <div class="space-y-4">
                                    @foreach($activeTickets as $trx)
                                        @foreach($trx->details as $detail)
                                            @php $concert = $detail->ticketCategory->concert ?? null; @endphp
                                            @if($concert)
                                                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-5 relative overflow-hidden group">
                                                    {{-- Decorative top border --}}
                                                    <div class="absolute top-0 left-0 w-full h-1 bg-blue-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                                    
                                                    {{-- QR Placeholder --}}
                                                    <div class="w-full sm:w-20 h-32 sm:h-20 bg-gray-50 sm:bg-gray-100 rounded-xl flex flex-col sm:flex-row items-center justify-center flex-shrink-0 border border-dashed border-gray-300 sm:border-none">
                                                        <svg class="w-10 h-10 text-gray-400 mb-2 sm:mb-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                                        </svg>
                                                        <span class="text-xs text-gray-400 font-medium sm:hidden">Tampilkan QR</span>
                                                    </div>
                                                    
                                                    <div class="flex-1 min-w-0 flex flex-col">
                                                        <div class="flex justify-between items-start gap-2 mb-1">
                                                            <p class="font-bold text-gray-900 truncate text-sm sm:text-base">{{ $concert->title }}</p>
                                                            <span class="px-2.5 py-0.5 text-[10px] sm:text-xs font-bold rounded-full bg-green-100 text-green-700 flex-shrink-0">AKTIF</span>
                                                        </div>
                                                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                                                            {{ $concert->event_date->translatedFormat('d M Y') }} &bull; {{ $concert->venue_name }}, {{ $concert->city }}
                                                        </p>

                                                        <div class="w-full border-t border-dashed border-gray-200 my-3 sm:hidden"></div>

                                                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-auto sm:mt-2">
                                                            <span class="text-[10px] sm:text-xs font-semibold bg-blue-50 text-blue-700 px-2 py-1 rounded-full">
                                                                {{ $detail->ticketCategory->category_name }}
                                                            </span>
                                                            <span class="text-[10px] sm:text-xs text-gray-400 font-medium">{{ $detail->quantity }} tiket</span>
                                                            <span class="text-[10px] sm:text-xs font-bold text-gray-700 bg-gray-50 px-2 py-1 rounded">{{ $trx->trx_code }}</span>

                                                            {{-- Tombol batalkan tiket --}}
                                                            <button type="button"
                                                                    @click="openCancelModal(
                                                                        '{{ route('transaksi.cancel', $trx) }}',
                                                                        '{{ addslashes($concert->title) }}',
                                                                        {{ $trx->isCancellable() ? 'true' : 'false' }}
                                                                    )"
                                                                    class="ml-auto text-[10px] sm:text-xs font-semibold text-red-500 hover:text-red-700 border border-red-200 hover:border-red-400 px-2.5 py-1 rounded-full transition-colors">
                                                                Batalkan Tiket
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-white rounded-2xl border border-gray-200 py-12 sm:py-16 px-4 text-center">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 sm:text-gray-500 font-semibold text-sm sm:text-base">Belum ada e-ticket aktif</p>
                                    <p class="text-xs sm:text-sm text-gray-400 mt-1">Beli tiket konser untuk memulai!</p>
                                    <a href="/konser" class="inline-block mt-5 sm:mt-4 px-6 py-2.5 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-full transition-colors w-full sm:w-auto">
                                        Lihat Konser
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Riwayat Pesanan --}}
                        <div id="riwayat" class="scroll-mt-24">
                            <div class="mb-4 sm:mb-6">
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">Riwayat Pesanan</h2>
                                <p class="text-gray-500 text-xs sm:text-sm">Semua transaksi yang pernah Anda lakukan.</p>
                            </div>

                            @if($transactions->count() > 0)
                                <div class="space-y-4">
                                    @foreach($transactions as $trx)
                                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                                            {{-- Header transaksi --}}
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between px-4 sm:px-5 py-4 border-b border-gray-100 gap-3 sm:gap-0">
                                                <div class="flex justify-between sm:block">
                                                    <div>
                                                        <p class="text-[10px] sm:text-xs text-gray-400 font-medium uppercase tracking-wider mb-0.5">Kode Transaksi</p>
                                                        <p class="font-bold text-gray-900 text-xs sm:text-sm">{{ $trx->trx_code }}</p>
                                                    </div>
                                                    <div class="text-right sm:hidden">
                                                        <p class="text-[10px] text-gray-400">{{ $trx->created_at->translatedFormat('d M Y') }}</p>
                                                        <p class="text-[10px] text-gray-400">{{ $trx->created_at->translatedFormat('H:i') }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center justify-between sm:block sm:text-right border-t border-gray-100 sm:border-0 pt-3 sm:pt-0">
                                                    <p class="text-[10px] sm:text-xs text-gray-400 hidden sm:block">{{ $trx->created_at->translatedFormat('d M Y, H:i') }}</p>
                                                    <span class="text-xs font-semibold sm:hidden text-gray-500">Status:</span>
                                                    @php
                                                        $statusMap = [
                                                            'pending'   => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-yellow-100 text-yellow-700'],
                                                            'paid'      => ['label' => 'Lunas',               'class' => 'bg-green-100 text-green-700'],
                                                            'cancelled' => ['label' => 'Dibatalkan',           'class' => 'bg-red-100 text-red-700'],
                                                        ];
                                                        $badge = $statusMap[$trx->status] ?? ['label' => ucfirst($trx->status), 'class' => 'bg-gray-100 text-gray-700'];
                                                    @endphp
                                                    <span class="inline-block sm:mt-1 px-2.5 py-1 sm:py-0.5 text-[10px] sm:text-xs font-bold rounded-full {{ $badge['class'] }}">
                                                        {{ $badge['label'] }}
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Detail item tiket --}}
                                            <div class="px-4 sm:px-5 py-3 space-y-3 sm:space-y-2">
                                                @foreach($trx->details as $detail)
                                                    @php $cat = $detail->ticketCategory; $concert = $cat->concert ?? null; @endphp
                                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between text-sm gap-1 sm:gap-0">
                                                        <div>
                                                            <p class="font-semibold text-gray-900 text-sm">{{ $concert->title ?? '—' }}</p>
                                                            <p class="text-gray-500 sm:text-gray-400 text-xs">{{ $cat->category_name ?? '—' }} &times; {{ $detail->quantity }} tiket</p>
                                                        </div>
                                                        <p class="font-bold sm:font-semibold text-gray-700 text-sm">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Footer total --}}
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between px-4 sm:px-5 py-3 sm:py-4 bg-gray-50 border-t border-gray-100 gap-2 sm:gap-0">
                                                <div class="text-xs text-gray-500 flex justify-between sm:block">
                                                    <span>Metode Pembayaran:</span>
                                                    <span class="font-semibold text-gray-700 sm:text-gray-500 capitalize ml-1">{{ str_replace('_', ' ', $trx->payment_method) }}</span>
                                                </div>
                                                <div class="flex justify-between items-end sm:block sm:text-right border-t border-gray-200 sm:border-0 pt-2 sm:pt-0">
                                                    <p class="text-xs text-gray-500 sm:text-gray-400">Total Bayar</p>
                                                    <p class="text-base sm:text-lg font-black text-blue-600">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-white rounded-2xl border border-gray-200 py-12 sm:py-16 px-4 text-center">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 sm:text-gray-500 font-semibold text-sm sm:text-base">Belum ada riwayat pesanan</p>
                                    <p class="text-xs sm:text-sm text-gray-400 mt-1">Mulai pesan tiket konser favoritmu!</p>
                                </div>
                            @endif
                        </div>

                        {{-- MODAL: Konfirmasi Batalkan Tiket --}}
                        <div x-show="cancelModal"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 z-50 flex items-center justify-center p-4"
                             style="display: none;">

                            <div @click="cancelModal = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

                            <div x-show="cancelModal"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 overflow-hidden">

                                <div class="flex flex-col items-center px-8 pt-8 pb-6 text-center">
                                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Batalkan Tiket?</h3>
                                    <p class="text-sm text-gray-500 leading-relaxed">
                                        Tiket konser <span class="font-semibold text-gray-800" x-text="'&quot;' + cancelTitle + '&quot;'"></span>
                                        akan dibatalkan. Untuk proses refund, silakan hubungi admin setelah pembatalan.
                                    </p>
                                </div>

                                <div class="flex gap-3 px-8 pb-6">
                                    <button type="button" @click="cancelModal = false"
                                            class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                                        Kembali
                                    </button>
                                    <form :action="cancelAction" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition-colors">
                                            Ya, Batalkan
                                        </button>
                                    </form>
                                </div>

                            </div>{{-- end modal panel --}}
                        </div>{{-- end cancel modal --}}

                        {{-- MODAL: Tidak Bisa Dibatalkan (H-7 sudah lewat) --}}
                        <div x-show="cancelBlockedModal"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 z-50 flex items-center justify-center p-4"
                             style="display: none;">

                            <div @click="cancelBlockedModal = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

                            <div x-show="cancelBlockedModal"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 overflow-hidden">

                                <div class="flex flex-col items-center px-8 pt-8 pb-6 text-center">
                                    <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Tidak Dapat Dibatalkan</h3>
                                    <p class="text-sm text-gray-500 leading-relaxed">
                                        Tiket konser <span class="font-semibold text-gray-800" x-text="'&quot;' + cancelTitle + '&quot;'"></span>
                                        tidak dapat dibatalkan karena kurang dari 7 hari sebelum konser dilaksanakan.
                                    </p>
                                </div>

                                <div class="px-8 pb-6">
                                    <button type="button" @click="cancelBlockedModal = false"
                                            class="w-full py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-semibold text-gray-700 transition-colors">
                                        Mengerti
                                    </button>
                                </div>

                            </div>{{-- end modal panel --}}
                        </div>{{-- end blocked modal --}}

                    </div>{{-- /main area (x-data) --}}
            </div>
        </div>

    </div>
</x-layout>
