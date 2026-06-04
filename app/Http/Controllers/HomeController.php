<?php

namespace App\Http\Controllers;

use App\Services\ConcertService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(ConcertService $concertService): View
    {
        $upcomingConcerts = $concertService->getUpcomingConcerts();
        $cities = $concertService->getActiveCities();
        $availableMonths = $concertService->getAvailableMonths();

        return view('home', compact('upcomingConcerts', 'cities', 'availableMonths'));
    }
}
