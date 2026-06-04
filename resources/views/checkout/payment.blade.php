<x-layout>
<div class="bg-slate-50 min-h-screen py-6 sm:py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── Stepper ── --}}
        <div class="flex items-center justify-center gap-2 sm:gap-3 mb-6 sm:mb-8 flex-wrap">
            <div class="flex items-center gap-1.5 sm:gap-2">
                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full border-2 border-blue-500 text-blue-500 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="font-bold text-slate-900 text-xs sm:text-sm">Keranjang</span>
            </div>
            <div class="h-0.5 w-6 sm:w-10 bg-blue-500 hidden sm:block"></div>
            <div class="flex items-center gap-1.5 sm:gap-2">
                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs sm:text-sm font-bold shadow-md shadow-blue-500/30">2</div>
                <span class="font-bold text-slate-900 text-xs sm:text-sm">Pembayaran</span>
            </div>
            <div class="h-0.5 w-6 sm:w-10 bg-slate-200 hidden sm:block"></div>
            <div class="flex items-center gap-1.5 sm:gap-2">
                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full border-2 border-slate-200 text-slate-300 flex items-center justify-center text-xs sm:text-sm font-bold">3</div>
                <span class="font-medium text-slate-300 text-xs sm:text-sm">Selesai</span>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-5 sm:mb-6 bg-red-50 border border-red-200 text-red-600 rounded-xl p-3 sm:p-4 text-xs sm:text-sm flex items-center gap-2 sm:gap-3">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('checkout.payment.process', $concert) }}" id="payment-form">
            @csrf
            <div class="flex flex-col md:flex-row gap-6 items-start">

                {{-- LEFT: Metode Pembayaran --}}
                <div class="flex-1 min-w-0 w-full">
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 mb-4">Metode Pembayaran</h2>

                    <div class="flex flex-col gap-3 mb-5 sm:mb-6">

                        {{-- Credit Card --}}
                        <label id="opt-credit_card" onclick="selectPayment('credit_card')" class="flex items-center gap-3 sm:gap-4 p-3.5 sm:p-4 border-2 border-blue-500 rounded-xl sm:rounded-2xl cursor-pointer bg-blue-50/50 shadow-sm transition-all duration-200">
                            <input type="radio" name="payment_method" value="credit_card" class="absolute opacity-0 pointer-events-none" checked>
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-slate-900 text-sm sm:text-base mb-0.5 truncate">Kartu Kredit / Debit</p>
                                <p class="text-xs sm:text-sm text-slate-400 m-0 truncate">Visa, Mastercard, JCB</p>
                            </div>
                            <div id="radio-credit_card" class="w-5 h-5 rounded-full border-2 border-blue-500 flex items-center justify-center shrink-0">
                                <div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div>
                            </div>
                        </label>

                        {{-- Transfer Bank --}}
                        <label id="opt-transfer" onclick="selectPayment('transfer')" class="flex items-center gap-3 sm:gap-4 p-3.5 sm:p-4 border-2 border-slate-200 rounded-xl sm:rounded-2xl cursor-pointer bg-white shadow-sm transition-all duration-200 hover:border-slate-300">
                            <input type="radio" name="payment_method" value="transfer" class="absolute opacity-0 pointer-events-none">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-slate-900 text-sm sm:text-base mb-0.5 truncate">Transfer Bank</p>
                                <p class="text-xs sm:text-sm text-slate-400 m-0 truncate">Akun Virtual (BCA, Mandiri, BNI)</p>
                            </div>
                            <div id="radio-transfer" class="w-5 h-5 rounded-full border-2 border-slate-200 shrink-0"></div>
                        </label>

                        {{-- Dompet Digital --}}
                        <label id="opt-ewallet" onclick="selectPayment('ewallet')" class="flex items-center gap-3 sm:gap-4 p-3.5 sm:p-4 border-2 border-slate-200 rounded-xl sm:rounded-2xl cursor-pointer bg-white shadow-sm transition-all duration-200 hover:border-slate-300">
                            <input type="radio" name="payment_method" value="ewallet" class="absolute opacity-0 pointer-events-none">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-purple-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-slate-900 text-sm sm:text-base mb-0.5 truncate">Dompet Digital</p>
                                <p class="text-xs sm:text-sm text-slate-400 m-0 truncate">GoPay, OVO, Dana</p>
                            </div>
                            <div id="radio-ewallet" class="w-5 h-5 rounded-full border-2 border-slate-200 shrink-0"></div>
                        </label>
                    </div>

                    {{-- Form Kartu Kredit --}}
                    <div id="card-form" class="bg-white border border-slate-200 rounded-xl sm:rounded-2xl p-4 sm:p-5 flex flex-col gap-4 shadow-sm mb-6">
                        <div>
                            <label class="block text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nomor Kartu</label>
                            <div class="flex items-center gap-2 sm:gap-3 bg-slate-50 border-2 border-slate-200 rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 focus-within:border-blue-400 focus-within:ring-1 focus-within:ring-blue-400 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                <input type="text" placeholder="0000 0000 0000 0000" maxlength="19"
                                    class="w-full bg-transparent border-none outline-none focus:ring-0 text-sm sm:text-base text-slate-700 placeholder-slate-400 p-0"
                                    oninput="formatCard(this)">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Pemegang Kartu</label>
                            <input type="text" placeholder="{{ auth()->user()->name ?? 'Budi Santoso' }}"
                                class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 transition-all outline-none text-sm sm:text-base text-slate-700 placeholder-slate-400">
                        </div>
                        <div class="grid grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Berlaku Sampai</label>
                                <input type="text" placeholder="MM/YY" maxlength="5"
                                    class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 transition-all outline-none text-sm sm:text-base text-slate-700 placeholder-slate-400"
                                    oninput="formatExpiry(this)">
                            </div>
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">CVV</label>
                                <input type="password" placeholder="•••" maxlength="4"
                                    class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 transition-all outline-none text-sm sm:text-base text-slate-700 placeholder-slate-400">
                            </div>
                        </div>
                    </div>

                    {{-- Form Transfer --}}
                    <div id="transfer-form" class="hidden bg-white border border-slate-200 rounded-xl sm:rounded-2xl p-4 sm:p-5 shadow-sm mb-6">
                        <p class="font-bold text-slate-900 text-sm sm:text-base mb-3 sm:mb-4">Pilih Bank</p>
                        <div class="grid grid-cols-3 gap-2 sm:gap-3">
                            @foreach(['BCA','Mandiri','BNI'] as $bank)
                            <button type="button" onclick="selectBank(this, '{{ $bank }}')"
                                class="px-2 py-3 border-2 border-slate-200 rounded-xl font-semibold text-xs sm:text-sm text-slate-600 hover:border-blue-300 hover:bg-blue-50 focus:outline-none transition-all text-center truncate">
                                {{ $bank }}
                            </button>
                            @endforeach
                        </div>
                        <p class="text-xs sm:text-sm text-slate-400 mt-4 leading-relaxed">Nomor virtual account akan digenerate secara otomatis setelah Anda mengonfirmasi pembayaran.</p>
                    </div>

                    {{-- Form E-Wallet --}}
                    <div id="ewallet-form" class="hidden bg-white border border-slate-200 rounded-xl sm:rounded-2xl p-4 sm:p-5 shadow-sm mb-6">
                        <p class="font-bold text-slate-900 text-sm sm:text-base mb-3 sm:mb-4">Pilih Dompet Digital</p>
                        <div class="grid grid-cols-3 gap-2 sm:gap-3">
                            @foreach(['GoPay','OVO','Dana'] as $wallet)
                            <button type="button" onclick="selectWallet(this, '{{ $wallet }}')"
                                class="px-2 py-3 border-2 border-slate-200 rounded-xl font-semibold text-xs sm:text-sm text-slate-600 hover:border-blue-300 hover:bg-blue-50 focus:outline-none transition-all text-center truncate">
                                {{ $wallet }}
                            </button>
                            @endforeach
                        </div>
                        <p class="text-xs sm:text-sm text-slate-400 mt-4 leading-relaxed">Anda akan diarahkan ke aplikasi dompet digital yang dipilih untuk menyelesaikan transaksi.</p>
                    </div>
                </div>

                {{-- RIGHT: Ringkasan --}}
                <div class="w-full md:w-[320px] shrink-0">
                    <div class="bg-[#1a2744] rounded-[24px] p-5 sm:p-6 text-white sticky top-20 sm:top-24 shadow-xl shadow-[#1a2744]/20">
                        <h3 class="font-extrabold text-sm sm:text-base mb-4 sm:mb-5">Ringkasan Tiket</h3>

                        <div class="flex flex-col gap-3 mb-4 sm:mb-5">
                            @foreach($lineItems as $item)
                            <div>
                                <div class="flex justify-between items-start text-xs sm:text-sm mb-0.5">
                                    <span class="text-white/60 truncate pr-2">{{ $concert->title }}</span>
                                    <span class="font-semibold text-white shrink-0">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                </div>
                                <div class="text-[10px] sm:text-xs text-white/40">{{ $item['qty'] }}× Tiket {{ $item['category']->category_name }}</div>
                            </div>
                            @endforeach

                            <div class="border-t border-white/10 my-1"></div>

                            <div class="flex justify-between items-center text-xs sm:text-sm">
                                <span class="text-white/50">Pajak & Biaya Sistem</span>
                                <span class="font-semibold text-white/70">Rp {{ number_format($tax + $serviceFee, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="bg-white/5 border border-white/10 rounded-xl p-3.5 sm:p-4 mb-4 sm:mb-5">
                            <p class="text-[10px] sm:text-xs font-bold text-white/40 uppercase tracking-widest mb-1">Total Tagihan</p>
                            <p class="text-2xl sm:text-3xl font-black text-blue-400 m-0">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
                        </div>

                        <button type="submit"
                            class="flex items-center justify-center gap-2 w-full py-3.5 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl text-sm sm:text-base transition-all shadow-lg shadow-blue-500/30 focus:outline-none focus:ring-4 focus:ring-blue-500/50 mb-4">
                            Konfirmasi & Bayar
                        </button>

                        <div class="flex items-start gap-2.5 sm:gap-3 bg-white/5 border border-white/10 rounded-xl p-3 sm:p-3.5">
                            <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-green-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-[10px] sm:text-xs text-white/40 m-0 leading-relaxed">
                                Dengan melanjutkan, Anda menyetujui Ketentuan Layanan. Transaksi dilindungi enkripsi 256-bit.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
const methods = ['credit_card', 'transfer', 'ewallet'];

function selectPayment(selected) {
    methods.forEach(m => {
        const opt   = document.getElementById('opt-' + m);
        const radio = document.getElementById('radio-' + m);
        const input = opt.querySelector('input[type=radio]');

        if (m === selected) {
            opt.classList.add('border-blue-500', 'bg-blue-50/50');
            opt.classList.remove('border-slate-200', 'bg-white', 'hover:border-slate-300');
            
            radio.classList.add('border-blue-500');
            radio.classList.remove('border-slate-200');
            radio.innerHTML = '<div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div>';
            
            input.checked = true;
        } else {
            opt.classList.remove('border-blue-500', 'bg-blue-50/50');
            opt.classList.add('border-slate-200', 'bg-white', 'hover:border-slate-300');
            
            radio.classList.remove('border-blue-500');
            radio.classList.add('border-slate-200');
            radio.innerHTML = '';
            
            input.checked = false;
        }
    });

    document.getElementById('card-form').style.display     = selected === 'credit_card' ? 'flex'  : 'none';
    document.getElementById('transfer-form').style.display = selected === 'transfer'    ? 'block' : 'none';
    document.getElementById('ewallet-form').style.display  = selected === 'ewallet'     ? 'block' : 'none';
}

function selectBank(btn, bank) {
    document.querySelectorAll('#transfer-form button').forEach(b => {
        b.classList.remove('border-blue-400', 'bg-blue-50', 'text-blue-600');
        b.classList.add('border-slate-200', 'text-slate-600');
    });
    btn.classList.remove('border-slate-200', 'text-slate-600');
    btn.classList.add('border-blue-400', 'bg-blue-50', 'text-blue-600');
}

function selectWallet(btn, wallet) {
    document.querySelectorAll('#ewallet-form button').forEach(b => {
        b.classList.remove('border-blue-400', 'bg-blue-50', 'text-blue-600');
        b.classList.add('border-slate-200', 'text-slate-600');
    });
    btn.classList.remove('border-slate-200', 'text-slate-600');
    btn.classList.add('border-blue-400', 'bg-blue-50', 'text-blue-600');
}

function formatCard(el) {
    let val = el.value.replace(/\D/g,'').substring(0,16);
    el.value = val.replace(/(.{4})/g,'$1 ').trim();
}

function formatExpiry(el) {
    let val = el.value.replace(/\D/g,'').substring(0,4);
    if (val.length >= 3) val = val.substring(0,2) + '/' + val.substring(2);
    el.value = val;
}
</script>
</x-layout>
