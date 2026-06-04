<x-layout>
<div style="background:#f8fafc; min-height:100vh; padding:24px 0;">
    <div style="max-width:1100px; margin:0 auto; padding:0 24px;">

        {{-- ── Stepper ── --}}
        <div style="display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:32px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:50%; border:2px solid #22c55e; color:#22c55e; display:flex; align-items:center; justify-content:center;">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span style="font-weight:500; color:#94a3b8; font-size:13px;">Keranjang</span>
            </div>
            <div style="height:2px; width:56px; background:#22c55e;"></div>
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:50%; border:2px solid #22c55e; color:#22c55e; display:flex; align-items:center; justify-content:center;">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span style="font-weight:500; color:#94a3b8; font-size:13px;">Pembayaran</span>
            </div>
            <div style="height:2px; width:56px; background:#22c55e;"></div>
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:50%; background:#22c55e; color:#fff; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; box-shadow:0 2px 8px rgba(34,197,94,0.35);">3</div>
                <span style="font-weight:700; color:#0f172a; font-size:13px;">Selesai</span>
            </div>
        </div>

        {{-- ── Success Card ── --}}
        <div style="max-width:500px; margin:0 auto;">
            <div style="background:#fff; border-radius:20px; box-shadow:0 4px 24px rgba(0,0,0,0.08); border:1px solid #f1f5f9; padding:40px 36px; text-align:center;">

                {{-- Animated Checkmark --}}
                <div style="position:relative; width:80px; height:80px; margin:0 auto 24px;">
                    <div style="position:absolute; inset:0; border-radius:50%; background:#dcfce7; animation:ping 1.5s ease-out 0.2s 1;"></div>
                    <div style="position:absolute; inset:8px; border-radius:50%; background:#f0fdf4; border:2px solid #fff; display:flex; align-items:center; justify-content:center; box-shadow:inset 0 1px 4px rgba(0,0,0,0.06);">
                        <div style="width:48px; height:48px; border-radius:50%; background:#22c55e; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(34,197,94,0.4);">
                            <svg class="checkmark" style="width:24px; height:24px;" fill="none" stroke="#fff" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <h1 style="font-size:22px; font-weight:900; color:#0f172a; margin:0 0 10px; letter-spacing:-0.02em;">Pembayaran Berhasil!</h1>
                <p style="color:#94a3b8; font-size:13px; line-height:1.7; max-width:340px; margin:0 auto 28px;">
                    Tiket Anda telah diterbitkan. E-Ticket telah dikirim ke email dan dapat diakses kapan saja melalui dasbor pengguna.
                </p>

                <div style="display:flex; flex-direction:column; align-items:center; gap:12px;">
                    <a href="{{ route('akun') }}"
                        style="display:inline-flex; align-items:center; justify-content:center; gap:8px; width:100%; max-width:300px; padding:13px 20px; background:#22c55e; color:#fff; font-weight:700; border-radius:12px; text-decoration:none; font-size:14px; box-shadow:0 4px 12px rgba(34,197,94,0.35); transition:background 0.2s;"
                        onmouseover="this.style.background='#16a34a'" onmouseout="this.style.background='#22c55e'">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 012 2v3a2 2 0 000 4v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3a2 2 0 000-4V7a2 2 0 012-2z"/></svg>
                        Akses Tiket Digital
                    </a>
                    <a href="{{ route('home') }}"
                        style="color:#94a3b8; text-decoration:none; font-weight:600; font-size:12px; text-transform:uppercase; letter-spacing:0.08em; transition:color 0.2s;"
                        onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
@keyframes ping {
  0%   { transform: scale(1); opacity: 0.4; }
  100% { transform: scale(1.8); opacity: 0; }
}
@keyframes draw {
  from { stroke-dashoffset: 60; opacity: 0; }
  to   { stroke-dashoffset: 0; opacity: 1; }
}
.checkmark path {
  stroke-dasharray: 60;
  stroke-dashoffset: 60;
  animation: draw 0.6s cubic-bezier(0.45, 0.05, 0.55, 0.95) forwards 0.4s;
}
</style>
</x-layout>
