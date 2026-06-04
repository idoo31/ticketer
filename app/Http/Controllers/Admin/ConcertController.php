<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreConcertRequest;
use App\Http\Requests\Admin\UpdateConcertRequest;
use App\Models\Artist;
use App\Models\Concert;
use App\Models\TicketCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ConcertController extends Controller
{
    /**
     * Display a listing of all concerts, with optional title search.
     */
    public function index(Request $request): View
    {
        $keyword = trim($request->input('q', ''));

        $concerts = Concert::select(['id', 'title', 'venue_name', 'city', 'event_date', 'event_time', 'status', 'banner_url', 'created_at'])
            ->with([
                'ticketCategories:id,concert_id,category_name,price,total_quota,available_quota',
                'artists:id,name,image_url',
            ])
            ->when($keyword, fn($q) => $q->where('title', 'like', "%{$keyword}%"))
            ->latest()
            ->get();

        $artists = Artist::active()->orderBy('name')->get(['id', 'name', 'genre']);

        return view('admin.layanan-konser', compact('concerts', 'keyword', 'artists'));
    }

    /**
     * Store a newly created concert in storage.
     */
    public function store(StoreConcertRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Handle banner upload
        $bannerUrl = null;
        if ($request->hasFile('banner')) {
            $bannerUrl = $request->file('banner')->store('concerts', 'public');
        }

        // Create the concert
        $concert = Concert::create([
            'title'       => $validated['title'],
            'venue_name'  => $validated['venue_name'],
            'city'        => $validated['city'],
            'event_date'  => $validated['event_date'],
            'event_time'  => $validated['event_time'],
            'description' => $validated['description'] ?? null,
            'status'      => $validated['status'],
            'banner_url'  => $bannerUrl,
        ]);

        // --- BULK INSERT: satu query untuk semua kategori tiket ---
        $now = now();
        $categoryRows = array_map(fn($cat) => [
            'concert_id'      => $concert->id,
            'category_name'   => $cat['category_name'],
            'price'           => $cat['price'],
            'total_quota'     => $cat['total_quota'],
            'available_quota' => $cat['total_quota'],
            'created_at'      => $now,
            'updated_at'      => $now,
        ], $validated['ticket_categories']);

        TicketCategory::insert($categoryRows);

        // Sync artis dengan urutan tampil
        $artistIds = collect($validated['artist_ids'])
            ->values()
            ->mapWithKeys(fn($id, $index) => [$id => ['order' => $index]])
            ->toArray();
        $concert->artists()->sync($artistIds);

        return redirect()
            ->route('admin.concerts.index')
            ->with('success', 'Konser "' . $concert->title . '" berhasil ditambahkan.');
    }

    /**
     * Show the edit form for a concert.
     */
    public function edit(Concert $concert): View
    {
        $concert->load(['ticketCategories', 'artists']);
        $artists = Artist::active()->orderBy('name')->get(['id', 'name', 'genre']);
        $selectedArtistIds = $concert->artists->pluck('id')->toArray();
        return view('admin.edit-konser', compact('concert', 'artists', 'selectedArtistIds'));
    }

    /**
     * Update a concert in storage.
     */
    public function update(UpdateConcertRequest $request, Concert $concert): RedirectResponse
    {
        $validated = $request->validated();

        // Handle banner upload — replace old one if new file uploaded
        $bannerUrl = $concert->banner_url;
        if ($request->hasFile('banner')) {
            if ($concert->banner_url) {
                Storage::disk('public')->delete($concert->banner_url);
            }
            $bannerUrl = $request->file('banner')->store('concerts', 'public');
        }

        // Update the concert
        $concert->update([
            'title'       => $validated['title'],
            'venue_name'  => $validated['venue_name'],
            'city'        => $validated['city'],
            'event_date'  => $validated['event_date'],
            'event_time'  => $validated['event_time'],
            'description' => $validated['description'] ?? null,
            'status'      => $validated['status'],
            'banner_url'  => $bannerUrl,
        ]);

        // Hapus semua kategori lama, lalu bulk insert yang baru
        $concert->ticketCategories()->delete();

        $now = now();
        $categoryRows = array_map(fn($cat) => [
            'concert_id'      => $concert->id,
            'category_name'   => $cat['category_name'],
            'price'           => $cat['price'],
            'total_quota'     => $cat['total_quota'],
            'available_quota' => $cat['total_quota'],
            'created_at'      => $now,
            'updated_at'      => $now,
        ], $validated['ticket_categories']);

        TicketCategory::insert($categoryRows);

        // Sync artis dengan urutan tampil
        $artistIds = collect($validated['artist_ids'])
            ->values()
            ->mapWithKeys(fn($id, $index) => [$id => ['order' => $index]])
            ->toArray();
        $concert->artists()->sync($artistIds);

        return redirect()
            ->route('admin.concerts.index')
            ->with('success', 'Konser "' . $concert->title . '" berhasil diperbarui.');
    }

    /**
     * Delete a concert.
     */
    public function destroy(Concert $concert): RedirectResponse
    {
        if ($concert->banner_url) {
            Storage::disk('public')->delete($concert->banner_url);
        }

        $title = $concert->title;
        $concert->delete();

        return redirect()
            ->route('admin.concerts.index')
            ->with('success', 'Konser "' . $title . '" berhasil dihapus.');
    }
}
