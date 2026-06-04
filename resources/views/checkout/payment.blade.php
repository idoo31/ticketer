<x-layout>
<div style="background:#f8fafc; min-height:100vh; padding:24px 0;">
    <div style="max-width:1100px; margin:0 auto; padding:0 24px;">

        {{-- ── Stepper ── --}}
        <div style="display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:50%; border:2px solid #3b82f6; color:#3b82f6; display:flex; align-items:center; justify-content:center;">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span style="font-weight:700; color:#0f172a; font-size:13px;">Keranjang</span>
            </div>
            <div style="height:2px; width:56px; background:#3b82f6;"></div>
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:50%; background:#3b82f6; color:#fff; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; box-shadow:0 2px 8px rgba(59,130,246,0.35);">2</div>
                <span style="font-weight:700; color:#0f172a; font-size:13px;">Pembayaran</span>
            </div>
            <div style="height:2px; width:56px; background:#e2e8f0;"></div>
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:50%; border:2px solid #e2e8f0; color:#cbd5e1; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700;">3</div>
                <span style="font-weight:500; color:#cbd5e1; font-size:13px;">Selesai</span>
            </div>
        </div>

        @if($errors->any())
            <div style="margin-bottom:20px; background:#fef2f2; border:1px solid #fecaca; color:#dc2626; border-radius:10px; padding:10px 16px; font-size:13px; display:flex; align-items:center; gap:8px;">
                <svg style="width:16px; height:16px; flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('checkout.payment.process', $concert) }}">
            @csrf
            <div style="display:flex; gap:20px; align-items:flex-start;">

                {{-- LEFT: Metode Pembayaran --}}
                <div style="flex:1; min-width:0;">
                    <h2 style="font-size:17px; font-weight:800; color:#0f172a; margin:0 0 16px;">Metode Pembayaran</h2>

                    <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:16px;">

                        {{-- Credit Card --}}
                        <label id="opt-credit_card" onclick="selectPayment('credit_card')" style="display:flex; align-items:center; gap:14px; padding:14px 16px; border:2px solid #3b82f6; border-radius:14px; cursor:pointer; background:rgba(239,246,255,0.5); box-shadow:0 1px 4px rgba(0,0,0,0.05); transition:all 0.2s;">
                            <input type="radio" name="payment_method" value="credit_card" style="position:absolute; opacity:0; pointer-events:none;" checked>
                            <div style="width:36px; height:36px; border-radius:10px; background:#dbeafe; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <svg style="width:18px;height:18px;" fill="none" stroke="#3b82f6" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div style="flex:1;">
                                <p style="font-weight:700; color:#0f172a; font-size:14px; margin:0 0 2px;">Kartu Kredit / Debit</p>
                                <p style="font-size:12px; color:#94a3b8; margin:0;">Visa, Mastercard, JCB</p>
                            </div>
                            <div id="radio-credit_card" style="width:18px; height:18px; border-radius:50%; border:2px solid #3b82f6; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <div style="width:8px; height:8px; border-radius:50%; background:#3b82f6;"></div>
                            </div>
                        </label>

                        {{-- Transfer Bank --}}
                        <label id="opt-transfer" onclick="selectPayment('transfer')" style="display:flex; align-items:center; gap:14px; padding:14px 16px; border:2px solid #e2e8f0; border-radius:14px; cursor:pointer; background:#fff; box-shadow:0 1px 4px rgba(0,0,0,0.04); transition:all 0.2s;">
                            <input type="radio" name="payment_method" value="transfer" style="position:absolute; opacity:0; pointer-events:none;">
                            <div style="width:36px; height:36px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <svg style="width:18px;height:18px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                </svg>
                            </div>
                            <div style="flex:1;">
                                <p style="font-weight:700; color:#0f172a; font-size:14px; margin:0 0 2px;">Transfer Bank</p>
                                <p style="font-size:12px; color:#94a3b8; margin:0;">Akun Virtual (BCA, Mandiri, BNI)</p>
                            </div>
                            <div id="radio-transfer" style="width:18px; height:18px; border-radius:50%; border:2px solid #e2e8f0; flex-shrink:0;"></div>
                        </label>

                        {{-- Dompet Digital --}}
                        <label id="opt-ewallet" onclick="selectPayment('ewallet')" style="display:flex; align-items:center; gap:14px; padding:14px 16px; border:2px solid #e2e8f0; border-radius:14px; cursor:pointer; background:#fff; box-shadow:0 1px 4px rgba(0,0,0,0.04); transition:all 0.2s;">
                            <input type="radio" name="payment_method" value="ewallet" style="position:absolute; opacity:0; pointer-events:none;">
                            <div style="width:36px; height:36px; border-radius:10px; background:#f3e8ff; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <svg style="width:18px;height:18px;" fill="none" stroke="#9333ea" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div style="flex:1;">
                                <p style="font-weight:700; color:#0f172a; font-size:14px; margin:0 0 2px;">Dompet Digital</p>
                                <p style="font-size:12px; color:#94a3b8; margin:0;">GoPay, OVO, Dana</p>
                            </div>
                            <div id="radio-ewallet" style="width:18px; height:18px; border-radius:50%; border:2px solid #e2e8f0; flex-shrink:0;"></div>
                        </label>
                    </div>

                    {{-- Form Kartu Kredit --}}
                    <div id="card-form" style="background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:20px; display:flex; flex-direction:column; gap:16px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                        <div>
                            <label style="display:block; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:8px;">Nomor Kartu</label>
                            <div style="display:flex; align-items:center; gap:10px; background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:10px; padding:11px 14px;">
                                <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                <input type="text" placeholder="0000 0000 0000 0000" maxlength="19"
                                    style="width:100%; background:transparent; border:none; outline:none; font-size:14px; color:#334155; font-family:inherit;"
                                    oninput="formatCard(this)">
                            </div>
                        </div>
                        <div>
                            <label style="display:block; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:8px;">Nama Pemegang Kartu</label>
                            <input type="text" placeholder="{{ auth()->user()->name ?? 'Budi Santoso' }}"
                                style="width:100%; background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:10px; padding:11px 14px; font-size:14px; color:#334155; outline:none; font-family:inherit; box-sizing:border-box;"
                                onfocus="this.style.borderColor='#93c5fd'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                            <div>
                                <label style="display:block; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:8px;">Berlaku Sampai</label>
                                <input type="text" placeholder="MM/YY" maxlength="5"
                                    style="width:100%; background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:10px; padding:11px 14px; font-size:14px; color:#334155; outline:none; font-family:inherit; box-sizing:border-box;"
                                    oninput="formatExpiry(this)" onfocus="this.style.borderColor='#93c5fd'" onblur="this.style.borderColor='#e2e8f0'">
                            </div>
                            <div>
                                <label style="display:block; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:8px;">CVV</label>
                                <input type="password" placeholder="•••" maxlength="4"
                                    style="width:100%; background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:10px; padding:11px 14px; font-size:14px; color:#334155; outline:none; font-family:inherit; box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#93c5fd'" onblur="this.style.borderColor='#e2e8f0'">
                            </div>
                        </div>
                    </div>

                    {{-- Form Transfer --}}
                    <div id="transfer-form" style="display:none; background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:20px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                        <p style="font-weight:700; color:#0f172a; margin:0 0 12px; font-size:14px;">Pilih Bank</p>
                        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px;">
                            @foreach(['BCA','Mandiri','BNI'] as $bank)
                            <button type="button" onclick="selectBank(this, '{{ $bank }}')"
                                style="padding:12px; border:1.5px solid #e2e8f0; border-radius:10px; font-weight:600; font-size:13px; color:#475569; cursor:pointer; background:#fff; transition:all 0.15s; font-family:inherit;">
                                {{ $bank }}
                            </button>
                            @endforeach
                        </div>
                        <p style="font-size:12px; color:#94a3b8; margin-top:14px; line-height:1.6;">Nomor virtual account akan digenerate secara otomatis setelah Anda mengonfirmasi pembayaran.</p>
                    </div>

                    {{-- Form E-Wallet --}}
                    <div id="ewallet-form" style="display:none; background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:20px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                        <p style="font-weight:700; color:#0f172a; margin:0 0 12px; font-size:14px;">Pilih Dompet Digital</p>
                        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px;">
                            @foreach(['GoPay','OVO','Dana'] as $wallet)
                            <button type="button" onclick="selectWallet(this, '{{ $wallet }}')"
                                style="padding:12px; border:1.5px solid #e2e8f0; border-radius:10px; font-weight:600; font-size:13px; color:#475569; cursor:pointer; background:#fff; transition:all 0.15s; font-family:inherit;">
                                {{ $wallet }}
                            </button>
                            @endforeach
                        </div>
                        <p style="font-size:12px; color:#94a3b8; margin-top:14px; line-height:1.6;">Anda akan diarahkan ke aplikasi dompet digital yang dipilih untuk menyelesaikan transaksi.</p>
                    </div>
                </div>

                {{-- RIGHT: Ringkasan --}}
                <div style="width:300px; flex-shrink:0;">
                    <div style="background:#1a2744; border-radius:18px; padding:20px; color:#fff; position:sticky; top:24px; box-shadow:0 4px 20px rgba(26,39,68,0.25);">
                        <h3 style="font-weight:800; font-size:15px; margin:0 0 16px;">Ringkasan Tiket</h3>

                        <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:16px;">
                            @foreach($lineItems as $item)
                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:13px;">
                                    <span style="color:rgba(255,255,255,0.5); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:150px;">{{ $concert->title }}</span>
                                    <span style="font-weight:600; flex-shrink:0; margin-left:8px;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                </div>
                                <div style="font-size:11px; color:rgba(255,255,255,0.3); margin-top:2px;">{{ $item['qty'] }}× Tiket {{ $item['category']->category_name }}</div>
                            </div>
                            @endforeach

                            <div style="border-top:1px solid rgba(255,255,255,0.1); margin:4px 0;"></div>

                            <div style="display:flex; justify-content:space-between; font-size:13px;">
                                <span style="color:rgba(255,255,255,0.4);">Pajak & Biaya Sistem</span>
                                <span style="font-weight:600; color:rgba(255,255,255,0.6);">Rp {{ number_format($tax + $serviceFee, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:14px 16px; margin-bottom:16px;">
                            <p style="font-size:10px; color:rgba(255,255,255,0.4); margin:0 0 4px; text-transform:uppercase; letter-spacing:0.08em; font-weight:700;">Total Tagihan</p>
                            <p style="font-size:26px; font-weight:900; color:#60a5fa; margin:0;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
                        </div>

                        <button type="submit"
                            style="width:100%; padding:12px; background:#3b82f6; border:none; color:#fff; font-weight:700; border-radius:10px; font-size:13px; cursor:pointer; margin-bottom:12px; box-shadow:0 4px 12px rgba(59,130,246,0.35); transition:background 0.2s; font-family:inherit;"
                            onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                            Konfirmasi & Bayar
                        </button>

                        <div style="display:flex; align-items:flex-start; gap:10px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:10px; padding:12px;">
                            <div style="width:18px; height:18px; border-radius:50%; background:rgba(34,197,94,0.2); display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px;">
                                <svg style="width:11px;height:11px;" fill="#4ade80" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p style="font-size:11px; color:rgba(255,255,255,0.3); line-height:1.55; margin:0;">
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
            opt.style.borderColor   = '#3b82f6';
            opt.style.background    = 'rgba(239,246,255,0.5)';
            radio.style.borderColor = '#3b82f6';
            radio.innerHTML         = '<div style="width:8px;height:8px;border-radius:50%;background:#3b82f6;"></div>';
            input.checked           = true;
        } else {
            opt.style.borderColor   = '#e2e8f0';
            opt.style.background    = '#fff';
            radio.style.borderColor = '#e2e8f0';
            radio.innerHTML         = '';
            input.checked           = false;
        }
    });

    document.getElementById('card-form').style.display     = selected === 'credit_card' ? 'flex'  : 'none';
    document.getElementById('transfer-form').style.display = selected === 'transfer'    ? 'block' : 'none';
    document.getElementById('ewallet-form').style.display  = selected === 'ewallet'     ? 'block' : 'none';
}

function selectBank(btn, bank) {
    document.querySelectorAll('#transfer-form button').forEach(b => {
        b.style.borderColor = '#e2e8f0';
        b.style.color       = '#475569';
        b.style.background  = '#fff';
    });
    btn.style.borderColor = '#3b82f6';
    btn.style.color       = '#3b82f6';
    btn.style.background  = '#eff6ff';
}

function selectWallet(btn, wallet) {
    document.querySelectorAll('#ewallet-form button').forEach(b => {
        b.style.borderColor = '#e2e8f0';
        b.style.color       = '#475569';
        b.style.background  = '#fff';
    });
    btn.style.borderColor = '#3b82f6';
    btn.style.color       = '#3b82f6';
    btn.style.background  = '#eff6ff';
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
