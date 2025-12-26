@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
             <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Rekapitulasi Laporan Harian</h2>
             <p class="text-slate-500 mt-1">Laporan produksi harian dari semua operator.</p>
        </div>
        <a href="{{ route('daily-reports.monthly_yarn_usage', ['month' => $month, 'year' => $year, 'export' => 'true']) }}" class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-200 bg-green-600 rounded-xl hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Excel (Rekap Benang & Kain Bulanan)
        </a>
    </div>

    <!-- Tabs Navigation -->
    <div class="mb-6 border-b border-slate-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
            <li class="mr-2">
                <a href="{{ route('daily-reports.index') }}" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-slate-600 hover:border-slate-300 text-slate-500 transition-all font-bold">
                    Laporan Admin (Rekap)
                </a>
            </li>
            <li class="mr-2">
                <a href="{{ route('daily-reports.index') }}#details" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-slate-600 hover:border-slate-300 text-slate-500 transition-all font-bold">
                    Laporan Operator (Log Sheet Unit)
                </a>
            </li>
            <li class="mr-2">
                <a href="#" class="inline-block p-4 rounded-t-lg border-b-2 border-indigo-600 text-indigo-600 active hover:text-indigo-600 hover:border-indigo-600 transition-all font-bold">
                    Rekap Benang & Kain (Bulanan)
                </a>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <form action="{{ route('daily-reports.monthly_yarn_usage') }}" method="GET">
            <div class="flex flex-col md:flex-row md:items-end gap-4">
                <div class="w-full md:w-48">
                    <label for="month" class="block text-sm font-semibold text-slate-700 mb-2">Bulan</label>
                    <div class="relative">
                        <select name="month" id="month" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
                
                <div class="w-full md:w-32">
                    <label for="year" class="block text-sm font-semibold text-slate-700 mb-2">Tahun</label>
                    <select name="year" id="year" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                        @for($y = date('Y'); $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="flex gap-2 mt-4 md:mt-0">
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter Data
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Report Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mesin</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pattern</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Benang</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pemakaian (KG)</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hasil Kain (M)</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hasil Kain (KG)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($data as $row)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row->machine_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row->pattern ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $row->yarn_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-bold">
                                {{ number_format($row->total_usage_qty, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                {{ number_format($row->total_meter_count, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                {{ number_format($row->total_kg_count, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Tidak ada data untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
