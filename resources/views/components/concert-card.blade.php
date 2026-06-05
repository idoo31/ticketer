@props([
    'concert' => null,  // bisa pass object Concert langsung
    'image'   => null,
    'title'   => null,
    'subtitle'=> null,
    'dateLocation' => null,
    'price'   => null,
    'remaining' => null,
    'buttonText' => 'Pilih & Beli Tiket',
    'hideButton' => false
])

@php
    // Jika object Concert dikirim, ekstrak data dari model
    if ($concert) {
        $image        = $concert->banner_url
                            ? Storage::url($concert->banner_url)
                            : null;
        $title        = $concert->title;
        $subtitle     = $concert->description
                            ? \Str::limit($concert->description, 60)
                            : $concert->venue_name;
        $dateLocation = $concert->event_date->translatedFormat('d M Y') . ' · ' . $concert->city;
        $minPrice     = $concert->ticketCategories->min('price');
        $price        = $minPrice ? 'Rp ' . number_format($minPrice, 0, ',', '.') : null;
        $remaining    = $concert->ticketCategories->sum('available_quota');
    }
@endphp

<div class="bg-[#f8f9fa] rounded-2xl p-4 border border-gray-100 transition-transform hover:-translate-y-1 hover:shadow-lg duration-300">
    <div class="aspect-[4/3] w-full rounded-xl overflow-hidden mb-4 bg-gradient-to-br from-blue-100 to-blue-200">
        @if($image)
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7a2 2 0 0 1 2-2z"/>
                </svg>
            </div>
        @endif
    </div>

    <div class="mb-4">
        <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $title }}</h3>
        <p class="text-sm text-gray-500 mb-2">{{ $subtitle }}</p>
        <p class="text-xs text-gray-500">{{ $dateLocation }}</p>
    </div>

    @if(!$hideButton)
        @if($price)
            <div class="flex justify-between items-end mb-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                    <p class="font-semibold text-gray-900 text-sm">{{ $price }}</p>
                </div>
                @if($remaining)
                    <p class="text-xs text-gray-500">{{ $remaining }} tersisa</p>
                @endif
            </div>
        @else
            <div class="mb-4"></div>
        @endif

        <a href="{{ $concert ? route('concert.detail', $concert) : '#' }}"
            class="concert-btn w-full py-2.5 px-4 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-900 flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            {{ $buttonText }}
        </a>
    @endif
</div>
