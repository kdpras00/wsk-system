@extends('layouts.app')

@section('header', 'Rekapitulasi Laporan Saya')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
             <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Riwayat Laporan Produksi</h2>
             <p class="text-slate-500 mt-1">Daftar laporan harian yang telah Anda submit.</p>
        </div>
        <a href="{{ route('daily-reports.create') }}" class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-200 bg-slate-900 rounded-xl hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Buat Laporan Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Tanggal</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">No. Mesin</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Total Output (PCS)</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs text-center">Status</th>
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
                        {{ $report->details->sum('pcs_count') }}
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($report->status == 'Approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                Approved
                            </span>
                        @elseif($report->status == 'Rejected')
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200 shadow-sm" title="{{ $report->rejection_note }}">
                                Rejected (Info)
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                Pending
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                        Anda belum pernah membuat laporan.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
