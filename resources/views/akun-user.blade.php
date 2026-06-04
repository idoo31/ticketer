<x-layout>
    <div class="bg-gray-50 min-h-screen">

        {{-- ── Header / Profile ── --}}
        <div class="pt-12 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-6">
                    {{-- Avatar --}}
                    <div class="w-32 h-32 bg-white border-2 border-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-16 h-16 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>

                    {{-- Info --}}
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">{{ $user->name }}</h1>
                        <p class="text-sm text-gray-500 font-semibold">
                            {{ $user->email }}
                            &bull;
                            Bergabung Sejak {{ $user->created_at->translatedFormat('Y') }}
                        </p>
                        <span class="inline-block mt-2 px-3 py-1 text-xs font-semibold rounded-full
                            {{ $user->isAdmin() ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $user->isAdmin() ? 'Admin' : 'Customer' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Main Content ── --}}
        <div class="pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row gap-8">

                    {{-- ── Sidebar ── --}}
                    <div class="w-full md:w-72 flex-shrink-0">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
                            <nav class="space-y-2">
                                <a href="#tiket"
                                    class="flex items-center gap-3 px-4 py-4 bg-blue-600 text-white rounded-xl font-semibold shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                    Dompet Tiket
                                </a>
                                <a href="#riwayat"
                                    class="flex items-center gap-3 px-4 py-4 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-semibold transition-colors">
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
                                    <span class="text-sm text-gray-500">Total Transaksi</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $transactions->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center px-2">
                                    <span class="text-sm text-gray-500">Total Tiket</span>
                                    <span class="text-sm font-bold text-gray-900">
                                        {{ $transactions->flatMap->details->sum('quantity') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center px-2">
                                    <span class="text-sm text-gray-500">Total Pengeluaran</span>
                                    <span class="text-sm font-bold text-blue-600">
                                        Rp {{ number_format($transactions->sum('grand_total'), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Main Area ── --}}
                    <div class="flex-1 space-y-8">

                        {{-- E-Ticket Aktif --}}
                        <div id="tiket">
                            <div class="mb-4">
                                <h2 class="text-2xl font-bold text-gray-900 mb-1">E-Ticket Aktif Anda</h2>
                                <p class="text-gray-500 text-sm">Tunjukkan kode QR atau download PDF tiket untuk masuk ke area acara.</p>
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
                                                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex items-center gap-5">
                                                    {{-- QR Placeholder --}}
                                                    <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="font-bold text-gray-900 truncate">{{ $concert->title }}</p>
                                                        <p class="text-sm text-gray-500 mt-0.5">
                                                            {{ $concert->event_date->translatedFormat('d M Y') }} &bull; {{ $concert->venue_name }}, {{ $concert->city }}
                                                        </p>
                                                        <div class="flex items-center gap-3 mt-2">
                                                            <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-2 py-1 rounded-full">
                                                                {{ $detail->ticketCategory->category_name }}
                                                            </span>
                                                            <span class="text-xs text-gray-400">{{ $detail->quantity }} tiket</span>
                                                            <span class="text-xs font-bold text-gray-700">{{ $trx->trx_code }}</span>
                                                        </div>
                                                    </div>
                                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 flex-shrink-0">AKTIF</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-white rounded-2xl border border-gray-200 py-16 text-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold">Belum ada e-ticket aktif</p>
                                    <p class="text-sm text-gray-400 mt-1">Beli tiket konser untuk memulai!</p>
                                    <a href="/konser" class="inline-block mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-full transition-colors">
                                        Lihat Konser
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Riwayat Pesanan --}}
                        <div id="riwayat">
                            <div class="mb-4">
                                <h2 class="text-2xl font-bold text-gray-900 mb-1">Riwayat Pesanan</h2>
                                <p class="text-gray-500 text-sm">Semua transaksi yang pernah Anda lakukan.</p>
                            </div>

                            @if($transactions->count() > 0)
                                <div class="space-y-4">
                                    @foreach($transactions as $trx)
                                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                                            {{-- Header transaksi --}}
                                            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                                                <div>
                                                    <p class="text-xs text-gray-400 font-medium">Kode Transaksi</p>
                                                    <p class="font-bold text-gray-900 text-sm">{{ $trx->trx_code }}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-xs text-gray-400">{{ $trx->created_at->translatedFormat('d M Y, H:i') }}</p>
                                                    @php
                                                        $statusMap = [
                                                            'pending'   => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-yellow-100 text-yellow-700'],
                                                            'paid'      => ['label' => 'Lunas',               'class' => 'bg-green-100 text-green-700'],
                                                            'cancelled' => ['label' => 'Dibatalkan',           'class' => 'bg-red-100 text-red-700'],
                                                        ];
                                                        $badge = $statusMap[$trx->status] ?? ['label' => ucfirst($trx->status), 'class' => 'bg-gray-100 text-gray-700'];
                                                    @endphp
                                                    <span class="inline-block mt-1 px-2.5 py-0.5 text-xs font-bold rounded-full {{ $badge['class'] }}">
                                                        {{ $badge['label'] }}
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Detail item tiket --}}
                                            <div class="px-5 py-3 space-y-2">
                                                @foreach($trx->details as $detail)
                                                    @php $cat = $detail->ticketCategory; $concert = $cat->concert ?? null; @endphp
                                                    <div class="flex items-center justify-between text-sm">
                                                        <div>
                                                            <p class="font-semibold text-gray-900">{{ $concert->title ?? '—' }}</p>
                                                            <p class="text-gray-400 text-xs">{{ $cat->category_name ?? '—' }} &times; {{ $detail->quantity }}</p>
                                                        </div>
                                                        <p class="font-semibold text-gray-700">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Footer total --}}
                                            <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-t border-gray-100">
                                                <div class="text-xs text-gray-500">
                                                    Metode: <span class="font-semibold capitalize">{{ str_replace('_', ' ', $trx->payment_method) }}</span>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-xs text-gray-400">Total Bayar</p>
                                                    <p class="font-extrabold text-blue-600">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-white rounded-2xl border border-gray-200 py-16 text-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold">Belum ada riwayat pesanan</p>
                                    <p class="text-sm text-gray-400 mt-1">Mulai pesan tiket konser favoritmu!</p>
                                </div>
                            @endif
                        </div>

                    </div>{{-- /main area --}}
                </div>
            </div>
        </div>

    </div>
</x-layout>
