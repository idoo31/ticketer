<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Services\ConcertService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConcertPageController extends Controller
{
    public function index(Request $request, ConcertService $concertService): View
    {
        $keyword = trim($request->input('q', ''));
        $month   = trim($request->input('month', ''));  // format: "YYYY-MM"
        $city    = trim($request->input('city', ''));

        $hasFilter = $keyword !== '' || $month !== '' || $city !== '';

        $cities = $concertService->getActiveCities();
        $availableMonths = $concertService->getAvailableMonths();

        if ($hasFilter) {
            $concerts = Concert::select(Concert::listingColumns())
                ->with(['ticketCategories:id,concert_id,category_name,price,available_quota'])
                ->active()
                ->filter(compact('keyword', 'month', 'city'))
                ->orderBy('event_date', 'asc')
                ->get();
        } else {
            $concerts = $concertService->getActiveConcerts();
        }

        // ── "Paling Diminati": 4 konser paling baru (tidak dipengaruhi filter) ─
        $popularConcerts = $hasFilter
            ? collect()
            : $concerts->sortByDesc('created_at')->take(4)->values();

        return view('konser', compact(
            'concerts',
            'popularConcerts',
            'cities',
            'availableMonths',
            'keyword',
            'month',
            'city',
            'hasFilter'
        ));
    }

    public function show(Concert $concert): View
    {
        $concert->load('ticketCategories', 'artists');
        return view('konser-detail', compact('concert'));
    }
}
