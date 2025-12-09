@extends('layouts.app')

@section('header', 'Rekapitulasi Laporan Harian')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
             <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Rekapitulasi Laporan Harian</h2>
             <p class="text-slate-500 mt-1">Laporan produksi harian dari semua operator.</p>
        </div>
        <a href="{{ route('daily-reports.export') }}" target="_blank" class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-200 bg-green-600 rounded-xl hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Excel
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Tanggal</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">No. Mesin</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Operator</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Total Output (PCS)</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                @forelse($reports as $report)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-4 px-6 font-bold text-slate-900">
                        {{ $report->production_date->format('d M Y') }}
                    </td>
                    <td class="py-4 px-6 text-slate-600 font-medium">
                        {{ $report->machine_name }}
                    </td>
                    <td class="py-4 px-6 text-slate-600 font-medium">
                        {{ $report->user->name ?? 'Unknown' }}
                    </td>
                    <td class="py-4 px-6 text-slate-600 font-medium">
                        {{ $report->details->sum('pcs_count') }}
                    </td>
                    <td class="py-4 px-6 text-center">
                        <a href="{{ route('daily-reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Lihat Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                        Belum ada laporan harian yang masuk.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
