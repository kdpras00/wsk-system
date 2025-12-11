@extends('layouts.app')

@section('header', 'Tambah Jenis Kain')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Input Data Jenis Kain</h2>

        <form action="{{ route('fabrics.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Admin Management Fields (Admin fills this directly) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Yarn Source (Recipe) -->
                <div class="col-span-2">
                    <label for="yarn_material_id" class="block mb-2 text-sm font-bold text-slate-700">Jenis Benang (Bahan Baku)</label>
                    <select name="yarn_material_id" id="yarn_material_id" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" required>
                        <option value="">-- Pilih Bahan Baku Benang --</option>
                        @foreach($yarns as $yarn)
                            <option value="{{ $yarn->id }}">{{ $yarn->name }} (Stok: {{ $yarn->stock_quantity }})</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-500">Pilih benang yang digunakan untuk membuat kain ini.</p>
                </div>

                <!-- Pattern -->
                <div class="col-span-2">
                    <label for="pattern" class="block mb-2 text-sm font-bold text-slate-700">Nama Pattern</label>
                    <input type="text" name="pattern" id="pattern" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="Contoh: Cotton Combed 30s Red" required>
                    <p class="mt-1 text-xs text-slate-500">Masukkan nama jenis kain atau pattern yang dihasilkan.</p>
                </div>

                <!-- Jam (Time) -->
                <div>
                     <label for="jam" class="block mb-2 text-sm font-bold text-slate-700">Jam Produksi</label>
                     <input type="time" name="jam" id="jam" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" required>
                </div>

                <!-- No PCS -->
                <div>
                    <label for="no_pcs" class="block mb-2 text-sm font-bold text-slate-700">No. PCS / Kode Potong</label>
                    <input type="text" name="no_pcs" id="no_pcs" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="Contoh: A-123" required>
                </div>

                <!-- Meter -->
                <div>
                    <label for="meter" class="block mb-2 text-sm font-bold text-slate-700">Panjang (Meter)</label>
                    <input type="number" step="0.1" name="meter" id="meter" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="0.0" required>
                </div>

                <!-- Stok (Kg) -->
                <div>
                    <label for="stok_kg" class="block mb-2 text-sm font-bold text-slate-700">Stok Berat (Kg)</label>
                    <input type="number" step="0.01" name="stok_kg" id="stok_kg" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="0.00" required>
                </div>

                 <!-- Keterangan -->
                <div class="col-span-2">
                    <label for="keterangan" class="block mb-2 text-sm font-bold text-slate-700">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="Tambahan catatan..."></textarea>
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-slate-100">
                <a href="{{ route('yarns.index') }}" class="text-slate-500 bg-white hover:bg-slate-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-slate-200 text-sm font-medium px-5 py-2.5 hover:text-slate-900 focus:z-10 mr-3">
                    Batal
                </a>
                <button type="submit" class="text-white bg-slate-900 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center">
                    Simpan Data Kain
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
