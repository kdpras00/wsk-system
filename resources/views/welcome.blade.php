<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Produksi WSK') }}</title>

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
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Navbar -->
    <nav class="w-full py-6 px-8 flex justify-between items-center bg-white/50 backdrop-blur-sm border-b border-slate-200">
        <div class="flex items-center gap-3">
            <div class="bg-slate-900 p-1.5 rounded-lg shadow-sm">
                <img src="{{ asset('storage/logo-wsk.png') }}" class="h-6 w-auto" alt="Logo">
            </div>
            <span class="font-bold text-slate-800 tracking-tight text-lg">WSK SYSTEM</span>
        </div>
        <div>
            @if (Route::has('login'))
                <div class="flex gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-slate-600 hover:text-slate-900 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-semibold text-slate-700 hover:text-slate-900 transition-colors">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-semibold text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition-all shadow-md hover:shadow-lg inline-block">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center p-6 text-center">
        <div class="max-w-2xl mx-auto space-y-8 animate-fade-in-up">
            <div class="space-y-4">
                <span class="inline-block py-1 px-3 rounded-full bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-widest border border-slate-200">
                    Corporate Production Portal
                </span>
                <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Optimalkan Produksi <br>
                    <span class="text-slate-500">Dengan Presisi.</span>
                </h1>
                <p class="text-lg text-slate-500 max-w-xl mx-auto leading-relaxed">
                    Sistem manajemen produksi terintegrasi untuk pemantauan real-time, pelaporan akurat, veifikasi efisien dalam satu platform korporat yang modern.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-slate-900 text-white font-bold rounded-xl shadow-xl hover:bg-slate-800 transition-all transform hover:-translate-y-1 hover:shadow-2xl">
                        Akses Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-slate-900 text-white font-bold rounded-xl shadow-xl hover:bg-slate-800 transition-all transform hover:-translate-y-1 hover:shadow-2xl flex items-center justify-center gap-2">
                        Mulai Sekarang
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-700 font-bold rounded-xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-all">
                        Pelajari Lebih Lanjut
                    </a>
                @endauth
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-8 text-center text-slate-400 text-sm">
        &copy; {{ date('Y') }} WSK Production System. All rights reserved.
    </footer>

</body>
</html>
