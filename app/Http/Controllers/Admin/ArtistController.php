<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreArtistRequest;
use App\Http\Requests\Admin\UpdateArtistRequest;
use App\Models\Artist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    /**
     * Daftar artis dengan pencarian & filter genre.
     */
    public function index(Request $request): View
    {
        $keyword = trim($request->input('q', ''));
        $genre   = trim($request->input('genre', ''));

        $artists = Artist::withTrashed()
            ->when($keyword, fn($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->when($genre,   fn($q) => $q->where('genre', $genre))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        // Daftar genre unik untuk filter dropdown
        $genres = Artist::withTrashed()->whereNotNull('genre')->distinct()->orderBy('genre')->pluck('genre');

        return view('admin.artis', compact('artists', 'keyword', 'genre', 'genres'));
    }

    /**
     * Endpoint AJAX — kembalikan artis aktif dalam format JSON.
     * Digunakan oleh form tambah/edit konser untuk pencarian artis real-time.
     */
    public function search(Request $request)
    {
        $q = trim($request->input('q', ''));

        $artists = Artist::active()
            ->when($q, fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->orderBy('name')
            ->get(['id', 'name', 'genre']);

        return response()->json($artists);
    }

    /**
     * Simpan artis baru.
     */
    public function store(StoreArtistRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $photoUrl = $request->file('photo')->store('artists', 'public');
        }

        Artist::create([
            'name'          => $validated['name'],
            'slug'          => $validated['slug'],
            'genre'         => $validated['genre'] ?? null,
            'origin'        => $validated['origin'] ?? null,
            'image_url'     => $photoUrl,
            'instagram_url' => $validated['instagram_url'] ?? null,
            'is_active'     => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.artists.index')
            ->with('success', 'Artis "' . $validated['name'] . '" berhasil ditambahkan.');
    }

    /**
     * Form edit artis.
     */
    public function edit(Artist $artis): View
    {
        return view('admin.edit-artis', ['artist' => $artis]);
    }

    /**
     * Simpan perubahan artis.
     */
    public function update(UpdateArtistRequest $request, Artist $artis): RedirectResponse
    {
        $validated = $request->validated();

        $photoUrl = $artis->image_url;
        if ($request->hasFile('photo')) {
            if ($artis->image_url) {
                Storage::disk('public')->delete($artis->image_url);
            }
            $photoUrl = $request->file('photo')->store('artists', 'public');
        }

        $artis->update([
            'name'          => $validated['name'],
            'slug'          => $validated['slug'],
            'genre'         => $validated['genre'] ?? null,
            'origin'        => $validated['origin'] ?? null,
            'image_url'     => $photoUrl,
            'instagram_url' => $validated['instagram_url'] ?? null,
            'is_active'     => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.artists.index')
            ->with('success', 'Artis "' . $artis->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus artis (soft delete, setelah peringatan via JS).
     * Jika artis terhubung ke konser, soft-delete agar data historis terjaga.
     */
    public function destroy(Artist $artis): RedirectResponse
    {
        $concertCount = $artis->concerts()->count();

        // Soft delete artis — relasi pivot tetap ada, data historis konser aman
        $name = $artis->name;
        $artis->delete();

        $message = $concertCount > 0
            ? "Artis \"{$name}\" berhasil dinonaktifkan (terhubung {$concertCount} konser)."
            : "Artis \"{$name}\" berhasil dihapus.";

        return redirect()
            ->route('admin.artists.index')
            ->with('success', $message);
    }
}
