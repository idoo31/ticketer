@php
    use Illuminate\Support\Facades\Auth;
    if (!isset($navbarType)) {
        if (Auth::check()) {
            $navbarType = Auth::user()->role === 'admin' ? 'admin' : 'user';
        } else {
            $navbarType = 'guest';
        }
    }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TICKETER — Platform pemesanan tiket konser terpercaya di Indonesia. Temukan dan pesan tiket konser artis favoritmu dengan mudah dan aman.">
    <title>TICKETER - Pesan Tiket Konser</title>
    {{-- Preconnect untuk mempercepat load Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- font-display=swap mencegah invisible text saat font belum dimuat (FOIT) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff; /* Default bg */
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-gray-900">
    
    @if(!isset($hideNavbar) || !$hideNavbar)
        <x-navbar :type="$navbarType" />
    @endif

    <main class="flex-grow">
        {{ $slot }}
    </main>

    @if(!isset($hideFooter) || !$hideFooter)
        <x-footer />
    @endif

</body>
</html>
