<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Produksi WSK') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Modern Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-bottom: 1px solid #e2e8f0;
        }
        
        .sidebar-bg {
            background-color: #0f172a; /* Slate 900 */
        }
        
        .nav-item-active {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-left: 3px solid #ffffff;
        }
        
        .nav-item-inactive {
            color: #94a3b8; /* Slate 400 */
            border-left: 3px solid transparent;
        }
        
        .nav-item-inactive:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased relative min-h-screen">
    
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 z-50 w-72 h-screen transition-transform -translate-x-full md:translate-x-0 sidebar-bg shadow-xl" aria-label="Sidenav" id="drawer-navigation">
        <div class="flex flex-col h-full">
            <!-- Logo Section -->
            <div class="h-20 flex items-center px-6 border-b border-slate-800 bg-slate-900/50">
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3">
                     <div class="bg-white p-1 rounded-md shadow-sm">
                        <img src="{{ asset('storage/logo-wsk.png') }}" class="h-7 w-auto" alt="WSK Logo" /> 
                     </div>
                     <div class="flex flex-col">
                        <span class="text-white font-bold tracking-tight text-lg leading-none">WSK SYSTEM</span>
                        <span class="text-slate-400 text-[10px] font-medium uppercase tracking-widest mt-1">Corporate Portal</span>
                     </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                <div class="mb-2 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Main Menu</div>
                
                {{-- Common Dashboard --}}
                <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-sm font-medium rounded-r-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'nav-item-active' : 'nav-item-inactive' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                {{-- ADMIN ROLE --}}
                @if(Auth::user()->role === 'admin')
                    <div class="mt-8 mb-2 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Administration</div>

                    {{-- Kelola Data User --}}
                    <a href="{{ route('users.index') }}" class="flex items-center p-3 text-sm font-medium rounded-r-lg transition-all duration-200 {{ request()->routeIs('users.*') ? 'nav-item-active' : 'nav-item-inactive' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Kelola Data User
                    </a>

                    {{-- Kelola Bahan Benang --}}
                    <a href="{{ route('yarns.index') }}" class="flex items-center p-3 text-sm font-medium rounded-r-lg transition-all duration-200 {{ request()->routeIs('yarns.*') ? 'nav-item-active' : 'nav-item-inactive' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Kelola Bahan Benang
                    </a>
                    
                    {{-- Kelola Laporan (Previously Rekapitulasi Order / Admin Reports) --}}
                     <a href="{{ route('admin.reports.index') }}" class="flex items-center p-3 text-sm font-medium rounded-r-lg transition-all duration-200 {{ request()->routeIs('admin.reports.*') ? 'nav-item-active' : 'nav-item-inactive' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Kelola Laporan
                    </a>

                    {{-- Rekapitulasi Laporan (Digitized Daily Reports) --}}
                    <a href="{{ route('daily-reports.index') }}" class="flex items-center p-3 text-sm font-medium rounded-r-lg transition-all duration-200 {{ request()->routeIs('daily-reports.*') ? 'nav-item-active' : 'nav-item-inactive' }}">
                         <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Rekapitulasi Laporan
                    </a>
                @endif
                
                {{-- MANAGER ROLE --}}
                @if(Auth::user()->role === 'manager')
                    <div class="mt-8 mb-2 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Management</div>
                    
                    {{-- Verifikasi Laporan --}}
                    <a href="{{ route('production.index') }}" class="flex items-center p-3 text-sm font-medium rounded-r-lg transition-all duration-200 {{ request()->routeIs('production.*') ? 'nav-item-active' : 'nav-item-inactive' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Verifikasi Laporan
                    </a>

                     {{-- Rekapitulasi Laporan --}}
                     <a href="{{ route('daily-reports.index') }}" class="flex items-center p-3 text-sm font-medium rounded-r-lg transition-all duration-200 {{ request()->routeIs('daily-reports.*') ? 'nav-item-active' : 'nav-item-inactive' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Rekapitulasi Laporan
                    </a>
                @endif

                 {{-- OPERATOR ROLE --}}
                 @if(Auth::user()->role === 'operator')
                    <div class="mt-8 mb-2 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Operations</div>
                    
                    {{-- Kelola Laporan (Dropdown) --}}
                    <button type="button" class="flex items-center w-full p-3 text-sm font-medium rounded-r-lg transition-all duration-200 nav-item-inactive hover:bg-white/5" aria-controls="dropdown-kelola-laporan" data-collapse-toggle="dropdown-kelola-laporan">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="flex-1 text-left whitespace-nowrap">Kelola Laporan</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <ul id="dropdown-kelola-laporan" class="hidden py-1 space-y-1 bg-black/10 rounded-lg mx-2 my-1">
                        <li>
                            <a href="{{ route('daily-reports.create') }}" class="flex items-center p-2 pl-11 text-sm font-medium text-slate-300 rounded-lg hover:text-white hover:bg-white/10 transition-colors">
                                Input Laporan Harian
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('production.index') }}" class="flex items-center p-2 pl-11 text-sm font-medium text-slate-300 rounded-lg hover:text-white hover:bg-white/10 transition-colors">
                                Lihat Tasks (Produksi)
                            </a>
                        </li>
                    </ul>

                    {{-- Rekapitulasi Laporan --}}
                    <a href="{{ route('daily-reports.index') }}" class="flex items-center p-3 text-sm font-medium rounded-r-lg transition-all duration-200 {{ request()->routeIs('daily-reports.index') ? 'nav-item-active' : 'nav-item-inactive' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Rekapitulasi Laporan
                    </a>
                @endif
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <main class="md:ml-72 min-h-screen flex flex-col transition-all duration-300">
        <!-- Top Navbar (Glass) -->
        <nav class="glass-nav sticky top-0 z-40 px-6 py-3 flex justify-between items-center bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-sm">
            <div class="flex items-center gap-4">
                 <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation" aria-controls="drawer-navigation" class="p-2 text-slate-500 rounded-lg cursor-pointer md:hidden hover:text-slate-900 hover:bg-slate-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                 </button>
                 
                 <h1 class="text-xl font-bold text-slate-800 tracking-tight hidden sm:block">
                     @yield('header', 'Dashboard')
                 </h1>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Date Display -->
                <div class="hidden md:flex flex-col items-end mr-2">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Today</span>
                    <span class="text-sm font-bold text-slate-700">{{ now()->format('d M Y') }}</span>
                </div>

                <!-- Notifications (Mock) -->
                <button class="relative p-2 text-slate-400 hover:text-slate-600 transition-colors rounded-full hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-1.5 right-1.5 h-2.5 w-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                
                <!-- User Profile Dropdown -->
                <div class="relative ml-2" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 hover:bg-slate-50 rounded-full p-1 pr-3 transition-colors border border-transparent hover:border-slate-100">
                        <div class="h-9 w-9 rounded-full bg-slate-800 flex items-center justify-center text-white font-bold text-sm shadow ring-2 ring-white">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="hidden md:flex flex-col items-start">
                            <span class="text-sm font-bold text-slate-700 leading-none">{{ Auth::user()->name ?? 'Guest' }}</span>
                            <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider mt-0.5">{{ Auth::user()->role ?? 'User' }}</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-300 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 border border-slate-100 z-50 origin-top-right" style="display: none;">
                        <div class="px-4 py-3 border-b border-slate-50 md:hidden">
                            <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name ?? 'Guest' }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? '' }}</p>
                        </div>
                        {{-- Profile Settings Removed --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="flex-1 p-6 md:p-8 overflow-y-auto">
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: "{{ session('success') }}"
                        })
                    });
                </script>
            @endif
            
            @yield('content')
        </div>
        
        <!-- Footer -->
        <footer class="mt-auto px-8 py-6 text-center text-xs text-slate-400 border-t border-slate-200 bg-slate-50">
            &copy; {{ date('Y') }} WSK Production System. All rights reserved.
        </footer>
    </main>
  
  </body>
</html>
