<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\SaveCartRequest;
use App\Http\Requests\Checkout\ProcessPaymentRequest;
use App\Models\Concert;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Step 1 – Cart: tampilkan pilihan tiket dari concert detail.
     */
    public function cart(Request $request, Concert $concert, CheckoutService $checkoutService): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('info', 'Silakan login terlebih dahulu untuk membeli tiket.');
        }

        $concert->load('ticketCategories', 'artists');

        // Ambil pilihan tiket dari session (jika ada)
        $cart = session()->get("cart.{$concert->id}", []);

        if (empty($cart)) {
            return redirect()->route('concert.detail', $concert)
                ->with('info', 'Pilih tiket terlebih dahulu.');
        }

        // Hitung ringkasan
        $lineItems = $checkoutService->buildLineItems($concert, $cart);
        $totals = $checkoutService->calculateTotals($lineItems);

        return view('checkout.cart', array_merge(compact('concert', 'lineItems'), $totals));
    }

    /**
     * Step 1 → Step 1.5 (Review Cart): simpan pilihan ke session, lanjut ke review keranjang.
     */
    public function saveCart(SaveCartRequest $request, Concert $concert): RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return back()->withErrors(['tickets' => 'Sebagai admin, Anda tidak dapat melakukan pembelian tiket.']);
        }

        $validated = $request->validated();

        // Hanya simpan tiket dengan qty > 0
        $selected = [];
        foreach ($validated['tickets'] as $catId => $data) {
            $qty = (int) ($data['qty'] ?? 0);
            if ($qty > 0) {
                $selected[$catId] = ['qty' => $qty];
            }
        }

        if (empty($selected)) {
            return back()->withErrors(['tickets' => 'Pilih minimal 1 tiket dengan jumlah lebih dari 0.']);
        }

        session()->put("cart.{$concert->id}", $selected);

        return redirect()->route('checkout.cart', $concert);
    }

    /**
     * Step 2 – Payment: tampilkan metode pembayaran + ringkasan.
     */
    public function payment(Concert $concert, CheckoutService $checkoutService): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = session()->get("cart.{$concert->id}", []);
        if (empty($cart)) {
            return redirect()->route('checkout.cart', $concert)
                ->withErrors(['tickets' => 'Keranjang kosong, pilih tiket terlebih dahulu.']);
        }

        $concert->load('ticketCategories');

        // Hitung ringkasan
        $lineItems = $checkoutService->buildLineItems($concert, $cart);
        $totals = $checkoutService->calculateTotals($lineItems);

        return view('checkout.payment', array_merge(compact('concert', 'lineItems'), $totals));
    }

    /**
     * Step 2 → Step 3: proses transaksi, simpan ke DB.
     */
    public function processPayment(ProcessPaymentRequest $request, Concert $concert, CheckoutService $checkoutService): RedirectResponse
    {
        $cart = session()->get("cart.{$concert->id}", []);
        if (empty($cart)) {
            return redirect()->route('checkout.cart', $concert);
        }

        $concert->load('ticketCategories');
        $lineItems = $checkoutService->buildLineItems($concert, $cart);
        $totals = $checkoutService->calculateTotals($lineItems);

        // Validate quota
        $quotaErrors = $checkoutService->validateQuotas($lineItems);
        if ($quotaErrors) {
            return back()->withErrors($quotaErrors);
        }

        // Process payment
        $checkoutService->processPayment(Auth::id(), $request->validated('payment_method'), $lineItems, $totals);

        // Bersihkan cart setelah berhasil
        session()->forget("cart.{$concert->id}");

        return redirect()->route('checkout.success', $concert);
    }

    /**
     * Step 3 – Halaman sukses.
     */
    public function success(Concert $concert): View
    {
        return view('checkout.success', compact('concert'));
    }
}
