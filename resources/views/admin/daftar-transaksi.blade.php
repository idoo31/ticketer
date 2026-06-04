<x-admin-layout title="Management Transaksi">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex items-center px-4 py-2 bg-white rounded-xl border border-gray-200 w-full sm:w-[400px]">
            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari ID resi atau ID pengguna..." class="w-full bg-transparent border-none focus:ring-0 text-sm outline-none text-gray-900 placeholder-gray-400">
            @if(request('q'))
                <a href="{{ route('admin.transactions.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </form>
        
        <div class="flex items-center gap-3">
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition-colors shadow-sm">
                Semua situs
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <div class="min-w-[900px]">
                <!-- Table Header -->
                <div class="bg-[#1f2937] px-6 py-4 grid grid-cols-12 gap-4 items-center">
            <div class="col-span-2 text-xs font-semibold text-gray-300">ID & Tanggal Resi</div>
            <div class="col-span-2 text-xs font-semibold text-gray-300">Kredensial Pengguna</div>
            <div class="col-span-4 text-xs font-semibold text-gray-300">Informasi Item</div>
            <div class="col-span-2 text-xs font-semibold text-gray-300 text-right">Pendapatan</div>
            <div class="col-span-2 text-xs font-semibold text-gray-300 text-center">Status Validasi</div>
        </div>

        <!-- Table Body -->
        <div class="divide-y divide-gray-100">
            @forelse($transactions as $trx)
                @php
                    $statusBadge = match($trx->status) {
                        'paid'      => 'bg-green-100 text-green-700',
                        'pending'   => 'bg-orange-50 text-orange-600',
                        'cancelled' => 'bg-red-100 text-red-600',
                        'failed'    => 'bg-red-100 text-red-600',
                        default     => 'bg-gray-100 text-gray-600',
                    };
                    $statusLabel = match($trx->status) {
                        'paid'      => 'Success',
                        'pending'   => 'Pending',
                        'cancelled' => 'Batal',
                        'failed'    => 'Gagal',
                        default     => ucfirst($trx->status),
                    };
                @endphp
                <div class="px-6 py-5 grid grid-cols-12 gap-4 items-center hover:bg-gray-50/50 transition-colors cursor-pointer" onclick="openTransactionModal({{ $trx->id }})">
                    <div class="col-span-2">
                        <p class="font-bold text-xs text-gray-900 mb-1">{{ $trx->trx_code }}</p>
                        <p class="text-[10px] text-gray-500">{{ $trx->created_at->translatedFormat('d M Y, H:i') }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="font-bold text-xs text-gray-900 mb-1">{{ $trx->user->name ?? 'User terhapus' }}</p>
                        <p class="text-[10px] text-gray-500">{{ $trx->user->email ?? '-' }}</p>
                    </div>
                    <div class="col-span-4">
                        @foreach($trx->details as $detail)
                            <p class="text-xs font-semibold text-gray-900 mb-1">
                                <span class="text-blue-600">{{ $detail->quantity }}x</span> 
                                {{ $detail->ticketCategory->concert->title ?? 'Konser' }} 
                                <span class="text-gray-400 font-normal">({{ $detail->ticketCategory->category_name ?? '-' }})</span>
                            </p>
                        @endforeach
                    </div>
                    <div class="col-span-2 text-right">
                        <p class="font-bold text-xs text-gray-900">Rp{{ number_format($trx->grand_total, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-span-2 flex justify-center">
                        <span class="inline-block px-3 py-1 rounded-full {{ $statusBadge }} text-[10px] font-bold">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center">
                    <p class="text-gray-400 text-sm">Tidak ada transaksi ditemukan.</p>
                </div>
            @endforelse
        </div>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($transactions->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    <!-- Transaction Detail Modal -->
    <div id="trxModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50 backdrop-blur-sm" aria-hidden="true" onclick="closeTransactionModal()"></div>

            <!-- Modal panel -->
            <div class="relative inline-block w-full max-w-2xl px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:p-6">
                
                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900" id="modal-title">Detail Transaksi</h3>
                        <p class="text-sm text-gray-500 mt-1" id="modal-trx-code">-</p>
                    </div>
                    <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" onclick="closeTransactionModal()">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="mt-4 space-y-6">
                    <!-- User & Status Info -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-xs text-gray-500 mb-1">Informasi Pembeli</p>
                            <p class="font-bold text-gray-900 text-sm" id="modal-user-name">-</p>
                            <p class="text-xs text-gray-600" id="modal-user-email">-</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl flex flex-col justify-center">
                            <p class="text-xs text-gray-500 mb-1">Status Pembayaran</p>
                            <div>
                                <span id="modal-status-badge" class="inline-block px-3 py-1 rounded-full text-[10px] font-bold">-</span>
                            </div>
                            <p class="text-xs text-gray-600 mt-2" id="modal-payment-method">Metode: -</p>
                            <p class="text-xs text-gray-600" id="modal-created-at">Tanggal: -</p>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-3">Item Pesanan</h4>
                        <div class="border border-gray-100 rounded-xl overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-items-tbody" class="bg-white divide-y divide-gray-100">
                                    <!-- Items will be injected here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-medium text-gray-900" id="modal-subtotal">-</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Pajak (10%)</span>
                            <span class="font-medium text-gray-900" id="modal-tax">-</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Biaya Layanan</span>
                            <span class="font-medium text-gray-900" id="modal-service-fee">-</span>
                        </div>
                        <div class="pt-2 mt-2 border-t border-gray-200 flex justify-between">
                            <span class="font-bold text-gray-900">Total Pembayaran</span>
                            <span class="font-bold text-blue-600 text-lg" id="modal-grand-total">-</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-6 flex justify-end">
                    <button type="button" class="px-6 py-2.5 bg-gray-100 text-gray-700 hover:bg-gray-200 font-semibold rounded-xl text-sm transition-colors" onclick="closeTransactionModal()">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        const transactionsData = @json($transactions->items());

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
        }

        function getStatusBadge(status) {
            switch(status) {
                case 'paid': return { class: 'bg-green-100 text-green-700', text: 'Success' };
                case 'pending': return { class: 'bg-orange-50 text-orange-600', text: 'Pending' };
                case 'cancelled': return { class: 'bg-red-100 text-red-600', text: 'Batal' };
                case 'failed': return { class: 'bg-red-100 text-red-600', text: 'Gagal' };
                default: return { class: 'bg-gray-100 text-gray-600', text: status };
            }
        }

        function openTransactionModal(id) {
            const trx = transactionsData.find(t => t.id === id);
            if (!trx) return;

            // Populate text fields
            document.getElementById('modal-trx-code').textContent = trx.trx_code;
            document.getElementById('modal-user-name').textContent = trx.user?.name || 'User terhapus';
            document.getElementById('modal-user-email').textContent = trx.user?.email || '-';
            
            document.getElementById('modal-payment-method').textContent = 'Metode: ' + (trx.payment_method ? trx.payment_method.toUpperCase() : '-');
            document.getElementById('modal-created-at').textContent = 'Tanggal: ' + formatDate(trx.created_at);

            // Populate status badge
            const statusInfo = getStatusBadge(trx.status);
            const badge = document.getElementById('modal-status-badge');
            badge.className = `inline-block px-3 py-1 rounded-full text-[10px] font-bold ${statusInfo.class}`;
            badge.textContent = statusInfo.text;

            // Populate totals
            document.getElementById('modal-subtotal').textContent = formatRupiah(trx.subtotal);
            document.getElementById('modal-tax').textContent = formatRupiah(trx.tax);
            document.getElementById('modal-service-fee').textContent = formatRupiah(trx.service_fee);
            document.getElementById('modal-grand-total').textContent = formatRupiah(trx.grand_total);

            // Populate items table
            const tbody = document.getElementById('modal-items-tbody');
            tbody.innerHTML = ''; // clear previous
            
            if (trx.details && trx.details.length > 0) {
                trx.details.forEach(detail => {
                    const concertTitle = detail.ticket_category?.concert?.title || 'Konser';
                    const categoryName = detail.ticket_category?.category_name || '-';
                    
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <p class="font-bold">${concertTitle}</p>
                            <p class="text-xs text-gray-500">${categoryName}</p>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 text-center font-semibold">${detail.quantity}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 text-right">${formatRupiah(detail.price_per_unit)}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 font-bold text-right">${formatRupiah(detail.subtotal)}</td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">Tidak ada detail item.</td></tr>`;
            }

            // Show modal
            document.getElementById('trxModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // prevent background scrolling
        }

        function closeTransactionModal() {
            document.getElementById('trxModal').classList.add('hidden');
            document.body.style.overflow = '';
        }
    </script>
</x-admin-layout>
