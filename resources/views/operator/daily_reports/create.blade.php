@extends('layouts.app')

@section('header', 'Input Laporan Produksi Harian')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
        <form action="{{ route('daily-reports.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Header Section -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                Terdapat kesalahan pada input Anda:
                            </p>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="machine_name" class="block mb-2 text-sm font-bold text-slate-700">Nomor Mesin / Machine No</label>
                    <input type="text" name="machine_name" id="machine_name" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="e.g. R.20" required>
                </div>
                <div>
                    <label for="production_date" class="block mb-2 text-sm font-bold text-slate-700">Tanggal / Date</label>
                    <input type="date" name="production_date" id="production_date" value="{{ date('Y-m-d') }}" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" required>
                </div>
            </div>

            <!-- Details Table -->
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4">Log Produksi per Shift</h3>
                <div class="overflow-x-auto border border-slate-200 rounded-lg">
                    <table class="w-full text-sm text-center text-slate-600">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-100">
                            <tr>
                                <th scope="col" class="px-3 py-3 w-24">Shift</th>
                                <th scope="col" class="px-3 py-3">Counter Awal</th>
                                <th scope="col" class="px-3 py-3">Counter Akhir</th>
                                <th scope="col" class="px-3 py-3">PCS</th>
                                <th scope="col" class="px-3 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach(['Shift I', 'Shift II', 'Shift III'] as $index => $shift)
                            <tr>
                                <td class="px-3 py-2 font-bold bg-slate-50">
                                    <input type="hidden" name="shifts[{{ $index }}][shift_name]" value="{{ $shift }}">
                                    {{ $shift }}
                                </td>
                                <td class="px-2 py-2">
                                    <input type="number" step="0.1" name="shifts[{{ $index }}][counter_start]" class="w-full px-2 py-1 text-sm border-gray-300 rounded focus:ring-slate-500 focus:border-slate-500" placeholder="0">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="number" step="0.1" name="shifts[{{ $index }}][counter_end]" class="w-full px-2 py-1 text-sm border-gray-300 rounded focus:ring-slate-500 focus:border-slate-500" placeholder="0">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="number" name="shifts[{{ $index }}][pcs_count]" class="w-full px-2 py-1 text-sm border-gray-300 rounded focus:ring-slate-500 focus:border-slate-500" placeholder="0">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="text" name="shifts[{{ $index }}][comment]" class="w-full px-2 py-1 text-sm border-gray-300 rounded focus:ring-slate-500 focus:border-slate-500" placeholder="Keterangan...">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="mt-2 text-xs text-slate-500">* Isi sesuai baris shift. Kosongkan jika tidak ada produksi.</p>
            </div>

            <!-- Notes Section -->
            <div>
                <label for="notes" class="block mb-2 text-sm font-bold text-slate-700">Catatan Tambahan / Grand Total Notes</label>
                <textarea name="notes" id="notes" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="Total Output, Masalah Umum, dll..."></textarea>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="text-white bg-slate-900 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center shadow-lg transition-all">
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
