@extends('layouts.app')

@section('header', 'Laporan')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Overview Produksi</h2>
        <p class="text-slate-500 mt-1">Ringkasan real-time aktivitas produksi dan status verifikasi.</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Total Produksi -->
        <div class="relative overflow-hidden bg-slate-900 rounded-2xl p-6 shadow-xl border border-slate-800">
            <div class="absolute right-0 top-0 h-full w-1/2 bg-slate-800/20 transform skew-x-12 translate-x-12"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                         <p class="text-slate-400 text-sm font-medium uppercase tracking-wider">Total Produksi</p>
                         <h3 class="text-3xl font-bold text-white mt-1">{{ $productions->count() }}</h3>
                    </div>
                    <div class="h-12 w-12 rounded-xl bg-white/10 flex items-center justify-center text-white backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-slate-400">
                    <span class="text-emerald-400 font-bold flex items-center mr-1">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        +12%
                    </span>
                    <span>dari bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Menunggu Verifikasi -->
        <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-100 hover:shadow-lg transition-shadow duration-300">
             <div class="flex items-center justify-between">
                <div>
                     <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Menunggu Verifikasi</p>
                     <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $productions->where('status', 'Planned')->count() }}</h3>
                </div>
                <div class="h-12 w-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
             <div class="mt-4 w-full bg-slate-100 rounded-full h-1.5">
                <div class="bg-slate-400 h-1.5 rounded-full" style="width: {{ $productions->count() > 0 ? ($productions->where('status', 'Planned')->count() / $productions->count()) * 100 : 0 }}%"></div>
            </div>
        </div>

        <!-- Card 3: Selesai -->
        <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-100 hover:shadow-lg transition-shadow duration-300">
             <div class="flex items-center justify-between">
                <div>
                     <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Selesai</p>
                     <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $productions->where('status', 'Completed')->count() }}</h3>
                </div>
                <div class="h-12 w-12 rounded-xl bg-slate-100 text-slate-900 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
             <div class="mt-4 w-full bg-slate-100 rounded-full h-1.5">
                <div class="bg-slate-900 h-1.5 rounded-full" style="width: {{ $productions->count() > 0 ? ($productions->where('status', 'Completed')->count() / $productions->count()) * 100 : 0 }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-lg font-bold text-slate-800">Aktivitas Produksi Terakhir</h3>
            <a href="{{ route('daily-reports.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold text-xs border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 tracking-wider">ID Order</th>
                        <th class="px-6 py-4 tracking-wider">Manager / Operator</th>
                        <th class="px-6 py-4 tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($productions as $production)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 font-bold text-indigo-600">
                            #{{ $production->order_number ?? $production->id }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600 mr-3">
                                    {{ substr($production->manager->name ?? '?', 0, 1) }}
                                </div>
                                <span class="font-medium text-slate-700">{{ $production->manager->name ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">
                            {{ $production->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusClasses = [
                                    'Planned' => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'In Progress' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'Completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'Cancelled' => 'bg-rose-100 text-rose-800 border-rose-200',
                                ];
                                $currentClass = $statusClasses[$production->status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border shadow-sm {{ $currentClass }}">
                                {{ $production->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="mt-2 block text-sm font-medium">Belum ada data produksi.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
