<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtistPageController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = trim($request->input('q', ''));

        $artists = Artist::active()
            ->when($keyword, fn($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->orderBy('name')
            ->get();

        return view('artis', compact('artists', 'keyword'));
    }
}
