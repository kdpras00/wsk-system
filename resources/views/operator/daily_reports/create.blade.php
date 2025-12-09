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

            @if(isset($order))
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 flex items-start gap-4">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900">Laporan untuk Order #{{ $order->order_number }}</h4>
                        <p class="text-sm text-blue-700 mt-1">
                            Item: {{ $order->items->first()->yarnMaterial->name ?? '-' }} | 
                            Target: {{ $order->items->first()->planned_quantity ?? 0 }} {{ $order->items->first()->yarnMaterial->unit ?? '' }}
                        </p>
                        <input type="hidden" name="production_order_id" value="{{ $order->id }}">
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
                                <th scope="col" class="px-3 py-3 w-48">
                                    Bahan Baku (Yarn)
                                    <span class="block text-[10px] text-slate-500 font-normal">Pilih untuk kurangi stok</span>
                                </th>
                                <th scope="col" class="px-3 py-3 w-24">Pakai (Qty)</th>
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
                                     <select name="shifts[{{ $index }}][yarn_material_id]" class="w-full px-2 py-1 text-xs border-gray-300 rounded focus:ring-slate-500 focus:border-slate-500">
                                        <option value="">-- Pilih --</option>
                                        @foreach($yarns as $yarn)
                                            <option value="{{ $yarn->id }}">
                                                {{ $yarn->name }} (Stok: {{ $yarn->stock_quantity }} {{ $yarn->unit }})
                                            </option>
                                        @endforeach
                                     </select>
                                </td>
                                <td class="px-2 py-2">
                                    <input type="number" step="0.01" min="0" name="shifts[{{ $index }}][usage_qty]" class="w-full px-2 py-1 text-sm border-gray-300 rounded focus:ring-slate-500 focus:border-slate-500" placeholder="0">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="number" step="0.1" min="0" name="shifts[{{ $index }}][counter_start]" class="w-full px-2 py-1 text-sm border-gray-300 rounded focus:ring-slate-500 focus:border-slate-500" placeholder="0">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="number" step="0.1" min="0" name="shifts[{{ $index }}][counter_end]" class="w-full px-2 py-1 text-sm border-gray-300 rounded focus:ring-slate-500 focus:border-slate-500" placeholder="0">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="number" min="0" name="shifts[{{ $index }}][pcs_count]" class="w-full px-2 py-1 text-sm border-gray-300 rounded focus:ring-slate-500 focus:border-slate-500" placeholder="0">
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
