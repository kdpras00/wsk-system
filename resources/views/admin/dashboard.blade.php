@extends('layouts.app')

@section('header', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-6 bg-white rounded-2xl shadow-sm border border-slate-200">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Good Morning, {{ Auth::user()->name }}!</h2>
            <p class="text-slate-500 mt-1">Here is the latest update for your production system.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 transition-colors">
                View Reports
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    
    <!-- Instructions Section -->
    @if(isset($instructions) && $instructions->count() > 0)
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-lg font-bold text-blue-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Instruksi Terbaru
            </h3>
        </div>
        <div class="space-y-3">
            @foreach($instructions as $instruction)
                <div class="bg-white p-3 rounded-md shadow-sm border border-blue-100">
                    <div class="flex justify-between items-start">
                        <span class="font-bold text-slate-800">{{ $instruction->title }}</span>
                        <span class="text-xs text-slate-400">{{ $instruction->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-slate-600 mt-1">{{ $instruction->description }}</p>
                    <div class="mt-2 text-xs text-slate-400">
                        Dari: <span class="font-medium text-slate-500">{{ $instruction->user->name ?? 'Manager' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Total Users</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ \App\Models\User::count() }}</h3>
                </div>
                <div class="p-3 bg-slate-100 rounded-xl text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-emerald-600">
                <span class="font-medium">Active</span>
            </div>
        </div>

        <!-- Production Orders -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Production Orders</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ \App\Models\ProductionOrder::count() }}</h3>
                </div>
                <div class="p-3 bg-slate-100 rounded-xl text-slate-600">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>
             <div class="mt-4 flex items-center text-sm text-slate-400">
                <span class="font-medium">Total Recorded</span>
            </div>
        </div>

        <!-- Pending Reports -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
             <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Pending</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ \App\Models\ProductionOrder::where('status', 'Pending')->count() }}</h3>
                </div>
                <div class="p-3 bg-orange-50 rounded-xl text-orange-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
              <div class="mt-4 flex items-center text-sm text-orange-500">
                <span class="font-medium">Needs Review</span>
            </div>
        </div>
        
         <!-- System Status -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
             <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">System Status</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">Online</h3>
                </div>
                 <div class="p-3 bg-emerald-50 rounded-xl text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                </div>
            </div>
             <div class="mt-4 flex items-center text-sm text-emerald-500">
                <span class="font-medium">All Systems Operational</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions / Recent Activity Placeholder -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 h-64 flex flex-col items-center justify-center text-center">
            <div class="p-4 bg-slate-50 rounded-full mb-4">
                 <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Analytics Dashboard</h3>
             <p class="text-slate-500 mt-2 max-w-xs">Detailed production analytics and reports will appear here in future updates.</p>
        </div>
         <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 h-64 flex flex-col items-center justify-center text-center">
             <div class="p-4 bg-slate-50 rounded-full mb-4">
                  <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
             </div>
             <h3 class="text-lg font-bold text-slate-800">Recent Activity Logs</h3>
             <p class="text-slate-500 mt-2 max-w-xs">System logs and user activities will be displayed in this section.</p>
        </div>
    </div>
</div>
@endsection
