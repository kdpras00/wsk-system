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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        
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
<body class="bg-gray-50 text-slate-800 antialiased relative min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 768 }" @resize.window="if (window.innerWidth >= 768) sidebarOpen = true">
    
    <!-- Sidebar -->
    <aside 
        class="fixed top-0 left-0 z-50 w-72 h-screen transition-transform duration-300 sidebar-bg shadow-xl -translate-x-full md:translate-x-0" 
        :class="{ '!translate-x-0': sidebarOpen, '!-translate-x-full': !sidebarOpen }"
        aria-label="Sidenav" 
        id="drawer-navigation"
    >
        <div class="flex flex-col h-full">
            <!-- Logo Section -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800 bg-slate-900/50">
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3">
                     <div class="bg-white p-1 rounded-md shadow-sm">
                        <img src="{{ asset('storage/logo-wsk.png') }}" class="h-7 w-auto" alt="WSK Logo" /> 
                     </div>
                     <div class="flex flex-col">
                        <span class="text-white font-bold tracking-tight text-lg leading-none">WSK SYSTEM</span>
                        <span class="text-slate-400 text-[10px] font-medium uppercase tracking-widest mt-1">Corporate Portal</span>
                     </div>
                </a>
                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
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
                        Kelola Pattern
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
    <main 
        class="md:ml-72 min-h-screen flex flex-col transition-all duration-300"
        :class="{ '!ml-0': !sidebarOpen }"
    >
        <!-- Top Navbar (Glass) -->
        <!-- Top Navbar -->
        <nav class="sticky top-0 z-40 bg-white border-b border-slate-200 shadow-sm transition-all duration-300">
            <div class="px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                     <!-- Toggle Button -->
                     <button @click="sidebarOpen = !sidebarOpen" class="p-2 -ml-2 text-slate-500 rounded-lg hover:text-slate-900 hover:bg-slate-100 focus:ring-4 focus:ring-slate-100 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                     </button>
                     
                     <div class="hidden sm:flex flex-col">
                        <h1 class="text-xl font-bold text-slate-800 tracking-tight leading-none">
                            @yield('header', 'Dashboard')
                        </h1>
                     </div>
                </div>
                
                <div class="flex items-center gap-4 md:gap-6">
                    <!-- Date Display -->
                    <div class="hidden lg:flex flex-col items-end border-r border-slate-200 pr-6 mr-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Today</span>
                        <span class="text-sm font-bold text-slate-700">{{ now()->format('d M Y') }}</span>
                    </div>

                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="relative p-2 text-slate-400 hover:text-slate-600 transition-colors rounded-full hover:bg-slate-50 focus:ring-4 focus:ring-slate-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <!-- Notification Badge -->
                            <span id="notification-badge" class="{{ Auth::user()->unreadNotifications->count() > 0 ? '' : 'hidden' }} absolute top-2 right-2 h-2.5 w-2.5 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                        </button>
                        
                        <script>
                            setInterval(function() {
                                fetch('{{ route("notifications.count") }}')
                                    .then(response => response.json())
                                    .then(data => {
                                        const badge = document.getElementById('notification-badge');
                                        if (data.count > 0) {
                                            badge.classList.remove('hidden');
                                        } else {
                                            badge.classList.add('hidden');
                                        }
                                    });
                            }, 30000); // Poll every 30s
                        </script>

                        <!-- Notification Dropdown -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-slate-100 z-50 origin-top-right overflow-hidden" style="display: none;">
                            <div class="px-4 py-3 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                                <h3 class="text-sm font-bold text-slate-800">Notifikasi</h3>
                                <span id="dropdown-count" class="{{ Auth::user()->unreadNotifications->count() > 0 ? '' : 'hidden' }} text-xs font-semibold text-white bg-red-500 px-2 py-0.5 rounded-full">{{ Auth::user()->unreadNotifications->count() }} Baru</span>
                            </div>
                            <div class="max-h-96 overflow-y-auto" id="notification-list">
                                @forelse(Auth::user()->unreadNotifications as $notification)
                                    <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0 relative">
                                        <div class="flex items-start">
                                            <div class="ml-3 w-0 flex-1">
                                                <p class="text-sm font-medium text-slate-900">{{ $notification->data['title'] ?? 'Info' }}</p>
                                                <p class="text-xs text-slate-500 mt-0.5">{{ $notification->data['message'] ?? '' }}</p>
                                                <p class="text-[10px] text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-8 text-center text-slate-500 text-sm">Tidak ada notifikasi baru.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notification Toast -->
                    <div id="notification-toast" class="fixed bottom-4 right-4 bg-white border-l-4 border-blue-500 shadow-xl rounded-r-lg p-4 w-80 hidden z-[100] transform transition-all duration-300 translate-y-10 opacity-0">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 text-blue-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900" id="toast-title">Notification</p>
                                <p class="text-xs text-gray-500 mt-1" id="toast-message">New message received.</p>
                            </div>
                            <button onclick="document.getElementById('notification-toast').classList.add('hidden')" class="ml-4 text-gray-400 hover:text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>

                    <script>
                        // Global Helper for SweetAlert Confirmations
                        function confirmFormSubmission(event, formId, title = 'Are you sure?', text = "You won't be able to revert this!", confirmBtnText = 'Yes, do it!', icon = 'warning') {
                            event.preventDefault();
                            Swal.fire({
                                title: title,
                                text: text,
                                icon: icon,
                                showCancelButton: true,
                                confirmButtonColor: '#10b981', // Emerald 500
                                cancelButtonColor: '#64748b', // Slate 500
                                confirmButtonText: confirmBtnText,
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById(formId).submit();
                                }
                            })
                        }

                        let lastNotifId = '{{ Auth::user()->unreadNotifications->first()->id ?? 0 }}';
                        
                        setInterval(function() {
                            fetch('{{ route("notifications.count") }}')
                                .then(response => response.json())
                                .then(data => {
                                    const badge = document.getElementById('notification-badge');
                                    const countSpan = document.getElementById('dropdown-count');
                                    
                                    if (data.count > 0) {
                                        badge.classList.remove('hidden');
                                        if(countSpan) {
                                            countSpan.innerText = data.count + ' Baru';
                                            countSpan.classList.remove('hidden');
                                        }
                                        
                                        // Check for new notification
                                        if (data.latest && data.latest.id !== lastNotifId) {
                                            lastNotifId = data.latest.id;
                                            showToast(data.latest.data.title, data.latest.data.message);
                                        }
                                    } else {
                                        badge.classList.add('hidden');
                                        if(countSpan) countSpan.classList.add('hidden');
                                    }
                                });
                        }, 10000); // Check every 10s

                        function showToast(title, message) {
                            const toast = document.getElementById('notification-toast');
                            document.getElementById('toast-title').innerText = title;
                            document.getElementById('toast-message').innerText = message;
                            
                            toast.classList.remove('hidden', 'translate-y-10', 'opacity-0');
                            
                            // Play sound? Optional.
                            
                            setTimeout(() => {
                                toast.classList.add('translate-y-10', 'opacity-0');
                                setTimeout(() => toast.classList.add('hidden'), 300);
                            }, 5000);
                        }
                    </script>
                    
                    <!-- User Profile -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 hover:bg-slate-50 rounded-full py-1 pl-1 pr-3 transition-all border border-transparent hover:border-slate-100 focus:ring-4 focus:ring-slate-100">
                            <img class="h-9 w-9 rounded-full object-cover shadow-sm ring-2 ring-white" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0f172a&color=fff" alt="{{ Auth::user()->name }}">
                            <div class="hidden md:flex flex-col items-start">
                                <span class="text-sm font-bold text-slate-700 leading-none">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider mt-0.5">{{ Auth::user()->role }}</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 hidden md:block transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-1 border border-slate-100 z-50 origin-top-right" style="display: none;">
                            <div class="px-4 py-3 border-b border-slate-50 md:hidden bg-slate-50/50">
                                <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Sign out
                                </button>
                            </form>
                        </div>
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
