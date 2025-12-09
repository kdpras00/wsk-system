@extends('layouts.app')

@section('header', 'Rekapitulasi Laporan Harian')

@section('content')
<div class="space-y-6">
    <!-- Header/Filter Placeholder -->
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-slate-800">Daftar Laporan Masuk</h2>
        <div>
            <!-- Date Filter could go here -->
            <span class="text-sm text-slate-500">Menampilkan laporan terbaru</span>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                    <th scope="col" class="px-6 py-3">No. Mesin</th>
                    <th scope="col" class="px-6 py-3">Operator</th>
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
                        {{ $report->user->name ?? 'Unknown' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $report->details->sum('pcs_count') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('daily-reports.show', $report->id) }}" class="font-medium text-blue-600 hover:underline">Lihat Detail</a>
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
@endsection
