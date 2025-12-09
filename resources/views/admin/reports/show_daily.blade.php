@extends('layouts.app')

@section('header', 'Detail Laporan Produksi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('daily-reports.index') }}" class="flex items-center text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
        <button onclick="window.print()" class="flex items-center text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak / PDF
        </button>
    </div>

    <!-- Paper-like Container -->
    <div class="bg-white p-8 shadow-lg border border-slate-200" style="min-height: 800px;">
        <!-- Header -->
        <div class="text-center border-b-2 border-slate-800 pb-4 mb-6">
            <h1 class="text-2xl font-bold text-slate-900 uppercase tracking-widest">Laporan Produksi Harian</h1>
            <p class="text-sm text-slate-500 font-medium">PT. WSK PRODUCTION SYSTEM</p>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div class="flex">
                <span class="font-bold w-32">Nomor Mesin:</span>
                <span class="border-b border-dotted border-slate-400 flex-1">{{ $productionReport->machine_name }}</span>
            </div>
            <div class="flex">
                <span class="font-bold w-32">Tanggal:</span>
                <span class="border-b border-dotted border-slate-400 flex-1">{{ $productionReport->production_date->format('d F Y') }}</span>
            </div>
            <div class="flex">
                <span class="font-bold w-32">Dibuat Oleh:</span>
                <span class="border-b border-dotted border-slate-400 flex-1">{{ $productionReport->user->name }}</span>
            </div>
        </div>

        <!-- Main Data Table (Excel-like) -->
        <table class="w-full border-collapse border border-slate-800 text-sm mb-6">
            <thead>
                <tr class="bg-slate-100 text-slate-900">
                    <th class="border border-slate-800 px-3 py-2 text-center w-20">Shift</th>
                    <th class="border border-slate-800 px-3 py-2 text-center">Counter Awal</th>
                    <th class="border border-slate-800 px-3 py-2 text-center">Counter Akhir</th>
                    <th class="border border-slate-800 px-3 py-2 text-center">Output (PCS)</th>
                    <th class="border border-slate-800 px-3 py-2 text-center">Keterangan / Masalah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productionReport->details as $detail)
                <tr>
                    <td class="border border-slate-800 px-3 py-2 font-bold text-center bg-slate-50">{{ $detail->shift_name }}</td>
                    <td class="border border-slate-800 px-3 py-2 text-right">{{ $detail->counter_start }}</td>
                    <td class="border border-slate-800 px-3 py-2 text-right">{{ $detail->counter_end }}</td>
                    <td class="border border-slate-800 px-3 py-2 text-right font-bold">{{ $detail->pcs_count }}</td>
                    <td class="border border-slate-800 px-3 py-2 text-left">{{ $detail->comment ?? '-' }}</td>
                </tr>
                @endforeach
                <!-- Footer Row -->
                <tr class="bg-slate-100 font-bold">
                    <td colspan="3" class="border border-slate-800 px-3 py-2 text-right">TOTAL</td>
                    <td class="border border-slate-800 px-3 py-2 text-right">{{ $productionReport->details->sum('pcs_count') }}</td>
                    <td class="border border-slate-800 px-3 py-2 bg-slate-200"></td>
                </tr>
            </tbody>
        </table>

        <!-- Notes / Footer -->
        <div class="border border-slate-800 p-4 min-h-[100px]">
            <span class="block font-bold mb-2">Catatan Tambahan:</span>
            <p class="text-slate-700 whitespace-pre-wrap">{{ $productionReport->notes ?? 'Tidak ada catatan tambahan.' }}</p>
        </div>

        <div class="mt-12 flex justify-end gap-16 px-8 text-center">
            <div>
                <p class="mb-16">Dibuat Oleh,</p>
                <div class="border-t border-slate-800 w-32 mx-auto"></div>
                <p class="font-bold mt-1">{{ $productionReport->user->name }}</p>
            </div>
            <div>
                <p class="mb-16">Diperiksa Oleh,</p>
                <div class="border-t border-slate-800 w-32 mx-auto"></div>
                <p class="font-bold mt-1">( Manager )</p>
            </div>
        </div>
    </div>
</div>
@endsection
