@extends('layouts.app')

@section('header', 'Input Laporan Produksi Harian')

@section('content')
@section('content')
@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Admin-style Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Input Data Jenis Kain (Produksi)</h2>
        
        <form action="{{ route('daily-reports.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Global Fields Grouped -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50 p-6 rounded-xl border border-slate-100 mb-8">
                 <div>
                    <label for="production_date" class="block mb-2 text-sm font-bold text-slate-700">Tanggal</label>
                    <input type="date" name="production_date" id="production_date" value="{{ date('Y-m-d') }}" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" required>
                </div>
                <div>
                    <label for="shift_name" class="block mb-2 text-sm font-bold text-slate-700">Shift</label>
                    <select name="shift_name" id="shift_name" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        <option value="I">Shift I (Pagi)</option>
                        <option value="II">Shift II (Siang)</option>
                        <option value="III">Shift III (Malam)</option>
                    </select>
                </div>
                 <div>
                    <label for="machine_name" class="block mb-2 text-sm font-bold text-slate-700">Nomor Mesin</label>
                    <input type="text" name="machine_name" id="machine_name" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" placeholder="Contoh: 12-20" required>
                </div>
            </div>

            <!-- Table Section Header -->
            <div class="flex justify-between items-end mb-4 border-b border-slate-100 pb-4">
                <div>
                     <h3 class="text-lg font-bold text-slate-800">Detail Produksi</h3>
                     <p class="text-slate-500 text-xs mt-1">Masukkan detail pattern, meter, dan stok yang dihasilkan.</p>
                </div>
                <button type="button" onclick="addRow()" class="text-white bg-slate-900 hover:bg-slate-800 focus:ring-4 focus:ring-slate-300 font-medium rounded-lg text-xs px-4 py-2 flex items-center gap-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Baris
                </button>
            </div>
                
                <div class="overflow-x-auto border border-slate-200 rounded-lg shadow-sm">
                    <table class="w-full text-sm text-slate-600" id="logTable">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-100 border-b border-slate-200">
                            <tr>
                                <th scope="col" class="px-2 py-3 min-w-[150px] text-left pl-3">Jenis Benang</th>
                                <th scope="col" class="px-2 py-3 min-w-[150px] text-left pl-3">Pattern</th>
                                <th scope="col" class="px-2 py-3 w-[100px] text-center">Jam</th>
                                <th scope="col" class="px-2 py-3 w-[100px] text-center">Meter</th>
                                <th scope="col" class="px-2 py-3 w-[120px] text-center">No. PCS</th>
                                <th scope="col" class="px-2 py-3 w-[100px] text-center">Grade</th>
                                <th scope="col" class="px-2 py-3 w-[100px] text-center">Stok (Kg)</th>
                                <th scope="col" class="px-2 py-3 min-w-[200px] text-left pl-3">Posisi Putus</th>
                                <th scope="col" class="px-2 py-3 min-w-[150px] text-left pl-3">Masalah</th>
                                <th scope="col" class="px-2 py-3 min-w-[150px] text-left pl-3">Keterangan</th>
                                <th scope="col" class="px-2 py-3 w-[50px] text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white" id="logTableBody">
                            <!-- Rows will be added here via JS, defaulting one empty row -->
                             <tr class="group hover:bg-slate-50 transition-colors">
                                <td class="p-2">
                                    <select name="details[0][yarn_material_id]" class="w-full text-sm border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach($yarns as $yarn)
                                            <option value="{{ $yarn->id }}">
                                                {{ $yarn->name }} (Stok: {{ $yarn->stock_quantity }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-2">
                                    <input type="text" list="pattern_list" name="details[0][pattern]" onchange="autoSelectYarn(this)" class="w-full text-sm border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="Ketik Pattern..." required>
                                </td>
                                <td class="p-2"><input type="time" name="details[0][jam]" class="w-full text-sm text-center border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 bg-white h-10"></td>
                                <td class="p-2"><input type="number" step="0.01" name="details[0][meter_count]" class="w-full text-sm text-center border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="0"></td>
                                <td class="p-2"><input type="text" name="details[0][no_pcs]" class="w-full text-sm text-center border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="-"></td>
                                <td class="p-2">
                                    <select name="details[0][grade]" class="w-full text-sm text-center border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="BS">BS</option>
                                    </select>
                                </td>
                                <td class="p-2"><input type="number" step="0.01" name="details[0][usage_qty]" class="w-full text-sm text-center border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="0.00"></td>
                                <td class="p-2"><input type="text" name="details[0][posisi_benang_putus]" class="w-full text-sm text-left border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="Bar I, II..."></td>
                                <td class="p-2"><input type="text" name="details[0][kode_masalah]" class="w-full text-sm text-left border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="Kode"></td>
                                <td class="p-2"><input type="text" name="details[0][comment]" class="w-full text-sm text-left border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="..."></td>
                                <td class="p-2 text-center">
                                    <button type="button" onclick="removeRow(this)" class="text-slate-400 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Datalist for Pattern Suggestions (Shared) -->
            <datalist id="pattern_list">
                @foreach($patterns as $pattern)
                    <option value="{{ $pattern }}">
                @endforeach
            </datalist>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="text-white bg-slate-900 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-bold rounded-lg text-sm px-6 py-3 text-center shadow-lg transition-all w-full md:w-auto">
                    Simpan Laporan Harian
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let rowCount = 1;
    
    // Mapping from Pattern Name -> Yarn ID (from Backend)
    const fabricMap = @json($fabricMapping);

    // Pre-load yarn options from Blade 
    const yarnOptions = `
        <option value="">-- Pilih --</option>
        @foreach($yarns as $yarn)
            <option value="{{ $yarn->id }}">{{ $yarn->name }} (Stok: {{ $yarn->stock_quantity }})</option>
        @endforeach
    `;

    // Note: Pattern datalist is now in HTML, no need for patternOptions JS string

    function addRow() {
        const tbody = document.getElementById('logTableBody');
        const row = document.createElement('tr');
        row.className = 'group hover:bg-slate-50 transition-colors';
        row.innerHTML = `
            <td class="p-2">
                <select name="details[\${rowCount}][yarn_material_id]" class="w-full text-sm border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" required>
                    \${yarnOptions}
                </select>
            </td>
            <td class="p-2">
                 <input type="text" list="pattern_list" name="details[\${rowCount}][pattern]" onchange="autoSelectYarn(this)" class="w-full text-sm border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="Ketik Pattern..." required>
            </td>
            <td class="p-2">
                <input type="time" name="details[\${rowCount}][jam]" class="w-full text-sm border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" required>
            </td>
            <td class="p-2">
                <input type="number" step="0.01" name="details[\${rowCount}][meter_count]" class="w-full text-sm border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="0">
            </td>
            <td class="p-2">
                <input type="text" name="details[\${rowCount}][no_pcs]" class="w-full text-sm border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="PCS...">
            </td>
            <td class="p-2">
                <select name="details[\${rowCount}][grade]" class="w-full text-sm border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="BS">BS</option>
                </select>
            </td>
            <td class="p-2">
                <input type="number" step="0.01" name="details[\${rowCount}][usage_qty]" class="w-full text-sm border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="kg">
            </td>
             <td class="p-2"><input type="text" name="details[\${rowCount}][posisi_benang_putus]" class="w-full text-sm text-left border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="Bar I, II..."></td>
            <td class="p-2"><input type="text" name="details[\${rowCount}][kode_masalah]" class="w-full text-sm text-left border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="Kode"></td>
            <td class="p-2"><input type="text" name="details[\${rowCount}][comment]" class="w-full text-sm text-left border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500 h-10" placeholder="..."></td>
            <td class="p-2 text-center">
                <button type="button" onclick="removeRow(this)" class="text-slate-400 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </td>
        `;
        tbody.appendChild(row);
        rowCount++;
    }

    function removeRow(btn) {
        const row = btn.closest('tr');
        if (document.querySelectorAll('#logTableBody tr').length > 1) {
            row.remove();
        } else {
            // Optional: Clear values if it's the last row
            row.querySelectorAll('input, select').forEach(input => input.value = '');
        }
    }

    function autoSelectYarn(patternInput) {
        const patternName = patternInput.value;
        const row = patternInput.closest('tr');
        const yarnSelect = row.querySelector('select[name*="[yarn_material_id]"]'); // Find sibling yarn select
        
        if (patternName && fabricMap[patternName]) {
            const yarnId = fabricMap[patternName].yarn_material_id;
            if (yarnId) {
                yarnSelect.value = yarnId;
                // Visual feedback that it was auto-selected
                yarnSelect.classList.add('bg-green-50', 'text-green-700');
                setTimeout(() => {
                    yarnSelect.classList.remove('bg-green-50', 'text-green-700');
                }, 1000);
            }
        }
    }
</script>
@endsection
