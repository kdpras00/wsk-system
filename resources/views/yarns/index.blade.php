@extends('layouts.app')

@section('header', 'Manajemen Pattern')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Section 1: Gudang Bahan Baku (Benang) -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Gudang Bahan Baku (Benang)</h3>
                <p class="text-slate-500 text-xs mt-1">Stok benang yang tersedia untuk produksi.</p>
            </div>
            <a href="{{ route('yarns.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white transition-all duration-200 bg-slate-900 rounded-lg hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Stok Benang
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Nama Benang</th>
                        <th class="py-3 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Tipe</th>
                        <th class="py-3 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Update Terakhir</th>
                        <th class="py-3 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Stok Saat Ini</th>
                        <th class="py-3 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($yarns as $yarn)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-medium text-slate-900">{{ $yarn->name }}</td>
                        <td class="py-4 px-6 text-slate-600">{{ $yarn->type }}</td>
                        <td class="py-4 px-6 text-xs text-slate-500">{{ $yarn->updated_at->diffForHumans() }}</td>
                        <td class="py-4 px-6">
                             <div class="flex items-center gap-2">
                                <span class="font-bold {{ $yarn->stock_quantity < 10 ? 'text-red-600' : 'text-slate-700' }}">
                                    {{ $yarn->stock_quantity }}
                                </span>
                                <span class="text-slate-400 text-xs">{{ $yarn->unit }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('yarns.edit', $yarn->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-xs">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 text-sm">
                            Belum ada data stok benang.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $yarns->appends(['fabrics_page' => $fabrics->currentPage()])->links('vendor.pagination.custom') }}
        </div>
    </div>

    <!-- Section 2: Master Data Barang Jadi (Kain) -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-indigo-50/50">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Master Data Barang Jadi (Kain)</h3>
                <p class="text-slate-500 text-xs mt-1">Daftar jenis kain yang diproduksi (Resep BOM).</p>
            </div>
            <a href="{{ route('fabrics.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white transition-all duration-200 bg-black rounded-lg hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Jenis Kain
            </a>
        </div>

        <div class="overflow-x-auto">
             <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Nama Pattern</th>
                        <th class="py-3 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Bahan Baku (Resep)</th>
                        <th class="py-3 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Detail Standar</th>
                        <th class="py-3 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Total Stok</th>
                        <th class="py-3 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($fabrics as $fabric)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="font-bold text-slate-900">{{ $fabric->pattern }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">Created: {{ \Carbon\Carbon::parse($fabric->created_at)->format('d M Y') }}</div>
                        </td>
                        <td class="py-4 px-6">
                             @if($fabric->yarn_material_id)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ \App\Models\YarnMaterial::find($fabric->yarn_material_id)->name ?? 'Unknown' }}
                                </span>
                             @else
                                <span class="text-xs text-slate-400 italic">Belum diseting</span>
                             @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-xs text-slate-600">PCS: {{ $fabric->no_pcs }}</div>
                            <div class="text-xs text-slate-500">Meter: {{ $fabric->meter }}m</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-700">{{ $fabric->stok_kg }}</span>
                                <span class="text-slate-400 text-xs">kg</span>
                            </div>
                        </td>
                         <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                Active
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 text-sm">
                            Belum ada jenis kain. Silakan input Master Data.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $fabrics->appends(['yarns_page' => $yarns->currentPage()])->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
@endsection
