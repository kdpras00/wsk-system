@extends('layouts.app')

@section('header', 'Tambah Benang Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
        <form action="{{ route('yarns.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="col-span-2">
                    <label for="name" class="block mb-2 text-sm font-bold text-slate-700">Nama Benang / Item Name</label>
                    <input type="text" name="name" id="name" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="e.g. Cotton Combed 30s" required>
                </div>

                <!-- Type -->
                <div>
                     <label for="type" class="block mb-2 text-sm font-bold text-slate-700">Jenis / Type</label>
                    <input type="text" name="type" id="type" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="e.g. Combed" required>
                </div>

                 <!-- Color -->
                 <div>
                     <label for="color" class="block mb-2 text-sm font-bold text-slate-700">Warna / Color</label>
                    <input type="text" name="color" id="color" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="e.g. Hitam Pekat" required>
                </div>

                 <!-- Stock -->
                 <div>
                     <label for="stock_quantity" class="block mb-2 text-sm font-bold text-slate-700">Stok Awal</label>
                    <input type="number" step="0.01" min="0" name="stock_quantity" id="stock_quantity" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="0.00" required>
                </div>

                 <!-- Unit -->
                 <div>
                     <label for="unit" class="block mb-2 text-sm font-bold text-slate-700">Satuan</label>
                     <select name="unit" id="unit" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5">
                        <option value="kg">Kilogram (kg)</option>
                        <option value="rolls">Rolls</option>
                        <option value="pcs">Pcs</option>
                     </select>
                </div>
            </div>

            <div class="flex justify-end pt-4 gap-3">
                 <a href="{{ route('yarns.index') }}" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
                    Batal
                </a>
                <button type="submit" class="text-white bg-slate-900 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center shadow-lg transition-all">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
