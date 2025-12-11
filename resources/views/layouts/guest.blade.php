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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
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
    
    <!-- Global Loading Screen -->
    <div id="global-loader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 transition-opacity duration-500">
        <div class="text-center">
            <!-- WSK Logo with Pulse Animation -->
            <div class="mb-6 animate-pulse-slow">
                <img src="{{ asset('storage/logo-wsk.png') }}" class="h-24 w-auto mx-auto drop-shadow-2xl" alt="WSK Logo">
            </div>
            
            <!-- Loading Spinner -->
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <div class="w-16 h-16 border-4 border-slate-700 border-t-white rounded-full animate-spin"></div>
                    <div class="absolute inset-0 w-16 h-16 border-4 border-transparent border-t-blue-400 rounded-full animate-spin-slow"></div>
                </div>
            </div>
            
            <!-- Loading Text -->
            <p class="text-white text-sm font-medium tracking-wider animate-pulse">Loading...</p>
        </div>
    </div>

    <style>
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .animate-pulse-slow {
            animation: pulse-slow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }
        
        #global-loader.hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>

    <script>
        // Hide loader when page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(function() {
                const loader = document.getElementById('global-loader');
                if (loader) {
                    loader.classList.add('hidden');
                    // Remove from DOM after transition
                    setTimeout(function() {
                        loader.style.display = 'none';
                    }, 500);
                }
            }, 300); // Small delay for smooth transition
        });

        // Show loader on page navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Show loader when clicking links (except # links)
            document.querySelectorAll('a:not([href^="#"]):not([target="_blank"])').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    const loader = document.getElementById('global-loader');
                    if (loader && !e.ctrlKey && !e.metaKey) {
                        loader.style.display = 'flex';
                        loader.classList.remove('hidden');
                    }
                });
            });

            // Show loader on form submit
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function() {
                    const loader = document.getElementById('global-loader');
                    if (loader) {
                        loader.style.display = 'flex';
                        loader.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
</body>
</html>
