@extends('layouts.app')

@section('header', 'Rekapitulasi Laporan Saya')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-slate-800">Riwayat Laporan Produksi</h2>
        <a href="{{ route('daily-reports.create') }}" class="text-sm bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-slate-800 transition-colors">
            + Buat Laporan Baru
        </a>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                    <th scope="col" class="px-6 py-3">No. Mesin</th>
                    <th scope="col" class="px-6 py-3">Total Output (PCS)</th>
                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($reports as $report)
                <tr class="bg-white hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900">
                        {{ $report->production_date->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 font-bold">
                        {{ $report->machine_name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $report->details->sum('pcs_count') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <!-- View Only for now, Edit could be added -->
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                            Terkirim
                        </span>
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
@endsection
