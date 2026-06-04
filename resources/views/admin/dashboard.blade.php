<x-admin-layout title="Dashboard Utama">

    {{-- ══ Stat Cards ══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

        {{-- Total Pendapatan --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between h-[110px]">
            <div class="flex justify-between items-start">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base">$</div>
                <span class="bg-green-50 text-green-600 text-[10px] font-bold px-2 py-0.5 rounded-full">Live</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5">Total Pendapatan</p>
                <p class="text-lg font-bold text-gray-900">Rp{{ number_format($stats['totalRevenue'], 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Tiket Terjual --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between h-[110px]">
            <div class="flex justify-between items-start">
                <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
                <span class="bg-green-50 text-green-600 text-[10px] font-bold px-2 py-0.5 rounded-full">Live</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5">Tiket Terjual</p>
                <p class="text-lg font-bold text-gray-900">{{ number_format($stats['totalTickets'], 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Acara Aktif --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between h-[110px]">
            <div class="flex justify-between items-start">
                <div class="w-9 h-9 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="bg-green-50 text-green-600 text-[10px] font-bold px-2 py-0.5 rounded-full">Live</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5">Acara Aktif</p>
                <p class="text-lg font-bold text-gray-900">{{ $stats['activeConcerts'] }}</p>
            </div>
        </div>

        {{-- Total Pengguna --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between h-[110px]">
            <div class="flex justify-between items-start">
                <div class="w-9 h-9 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <span class="bg-green-50 text-green-600 text-[10px] font-bold px-2 py-0.5 rounded-full">Live</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5">Total Pengguna</p>
                <p class="text-lg font-bold text-gray-900">{{ number_format($stats['totalUsers'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- ══ Row 2: Chart + Transaksi Terbaru ════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

        {{-- Chart Pendapatan (data asli) --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-base">Pendapatan 6 Bulan Terakhir</h3>
                <span class="text-xs text-gray-400 font-medium">Hanya transaksi lunas</span>
            </div>

            {{-- Chart.js canvas --}}
            <div class="relative" style="height:220px;">
                <canvas id="revenueChart"></canvas>
            </div>

            {{-- Zero state jika semua nilai 0 --}}
            @if(array_sum($chartValues) == 0)
                <div class="absolute inset-0 flex items-center justify-center">
                    <p class="text-gray-400 text-sm">Belum ada data pendapatan</p>
                </div>
            @endif
        </div>

        {{-- Transaksi Terbaru --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-base">Transaksi Terbaru</h3>
                <a href="/admin/daftar-transaksi" class="text-xs text-blue-600 font-semibold hover:underline">Lihat semua</a>
            </div>

            <div class="space-y-4">
                @forelse($recentTransactions as $trx)
                    @php
                        $badge = match($trx->status) {
                            'paid'      => ['bg-green-50 text-green-700',  'Lunas'],
                            'pending'   => ['bg-orange-50 text-orange-600','Pending'],
                            'cancelled' => ['bg-red-50 text-red-600',      'Batal'],
                            'failed'    => ['bg-red-50 text-red-600',      'Gagal'],
                            default     => ['bg-gray-100 text-gray-500',   ucfirst($trx->status)],
                        };
                    @endphp
                    <div class="flex justify-between items-center {{ !$loop->first ? 'pt-4 border-t border-gray-50' : '' }}">
                        <div>
                            <p class="font-semibold text-sm text-gray-900 leading-tight">{{ $trx->user->name ?? '—' }}</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $trx->created_at->translatedFormat('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-sm text-gray-900 leading-tight">Rp{{ number_format($trx->grand_total, 0, ',', '.') }}</p>
                            <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full {{ $badge[0] }} text-[10px] font-bold">
                                {{ $badge[1] }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center">
                        <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p class="text-gray-400 text-sm">Belum ada transaksi</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ══ Row 3: Konser Terlaris ═══════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
            <h3 class="font-bold text-gray-900 text-base">Konser Terlaris</h3>
            <span class="text-xs text-gray-400">Berdasarkan tiket terjual (transaksi lunas)</span>
        </div>

        @if($topConcerts->isEmpty())
            <div class="py-12 text-center">
                <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 012 2v3a2 2 0 000 4v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3a2 2 0 000-4V7a2 2 0 012-2z"/></svg>
                <p class="text-gray-400 text-sm">Belum ada data penjualan tiket</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">#</th>
                            <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Konser</th>
                            <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th class="text-right px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Tiket Terjual</th>
                            <th class="text-right px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($topConcerts as $i => $concert)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-3.5">
                                    <span class="w-6 h-6 rounded-full {{ $i === 0 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-500' }} flex items-center justify-center text-xs font-bold">
                                        {{ $i + 1 }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $concert->title }}</p>
                                </td>
                                <td class="px-6 py-3.5 text-gray-500 text-xs">
                                    {{ $concert->event_date->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-3.5 text-right">
                                    <span class="font-bold text-gray-900">{{ number_format($concert->tickets_sold, 0, ',', '.') }}</span>
                                    <span class="text-gray-400 text-xs ml-1">tiket</span>
                                </td>
                                <td class="px-6 py-3.5 text-right font-bold text-gray-900">
                                    Rp{{ number_format($concert->revenue, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ══ Chart.js Script ══════════════════════════════════════════════════════ --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            const labels = @json($chartLabels);
            const values = @json($chartValues);

            const maxVal = Math.max(...values, 1);

            const ctx = document.getElementById('revenueChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: values,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.08)',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { size: 12, weight: '600' },
                            bodyFont: { size: 13, weight: '700' },
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID'),
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11, weight: '600' }, color: '#94a3b8' },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                            border: { display: false },
                            ticks: {
                                font: { size: 11 },
                                color: '#94a3b8',
                                maxTicksLimit: 5,
                                callback: val => {
                                    if (val >= 1_000_000) return 'Rp ' + (val / 1_000_000).toFixed(1) + 'jt';
                                    if (val >= 1_000)     return 'Rp ' + (val / 1_000).toFixed(0) + 'rb';
                                    return 'Rp ' + val;
                                }
                            }
                        }
                    }
                }
            });
        })();
    </script>

</x-admin-layout>
