<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserAccountController extends Controller
{
    /**
     * Show the user account / profile page.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Ambil semua transaksi beserta detail tiket dan info konser
        // Gunakan select kolom spesifik untuk efisiensi memory & kecepatan query
        $transactions = $user->transactions()
            ->select(['id', 'trx_code', 'subtotal', 'service_fee', 'tax', 'grand_total', 'payment_method', 'status', 'created_at', 'user_id'])
            ->with([
                'details:id,transaction_id,ticket_category_id,quantity,price_per_unit,subtotal',
                'details.ticketCategory:id,concert_id,category_name,price',
                'details.ticketCategory.concert:id,title,venue_name,city,event_date,banner_url',
            ])
            ->latest()
            ->get();

        return view('akun-user', compact('user', 'transactions'));
    }
}
