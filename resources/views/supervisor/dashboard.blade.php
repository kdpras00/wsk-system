@extends('layouts.app')

@section('header', 'Supervisor Overview')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-slate-900 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold">Supervisor Dashboard</h2>
            <p class="text-slate-400 mt-2 max-w-xl">Monitor active orders and production status.</p>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-white/10 to-transparent pointer-events-none"></div>
    </div>

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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Active Orders -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
             <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-4xl font-bold text-slate-800">{{ $activeOrders }}</h3>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-1">Active Orders</p>
                </div>
                <div class="h-12 w-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-6">
                <div class="bg-blue-600 h-1.5 rounded-full" style="width: 70%"></div>
            </div>
        </div>

        <!-- Total Yarn Material -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
             <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-4xl font-bold text-slate-800">{{ $totalYarn }}</h3>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-1">Yarn Types</p>
                </div>
                <div class="h-12 w-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-6">
                 <div class="bg-indigo-600 h-1.5 rounded-full" style="width: 45%"></div>
            </div>
        </div>
        
        <!-- Efficiency Mock -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
             <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-4xl font-bold text-slate-800">94%</h3>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-1">Efficiency</p>
                </div>
                <div class="h-12 w-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-6">
                 <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 94%"></div>
            </div>
        </div>
    </div>
</div>
@endsection
