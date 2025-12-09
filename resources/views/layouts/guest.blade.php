<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Produksi Benang') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased text-slate-800 relative min-h-screen overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover -z-20">
        <source src="{{ asset('storage/video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Dark Overlay -->
    <div class="fixed inset-0 bg-slate-900/60 -z-10 backdrop-blur-[2px]"></div>

    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-6 py-8 mx-auto">
        <!-- Main Card -->
        <div class="w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl border border-white/20 md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                @yield('content')
            </div>
        </div>
        
        <div class="mt-8 text-white/60 text-sm font-medium tracking-wide">
            &copy; {{ date('Y') }} WSK Production System
        </div>
    </div>
</body>
</html>
