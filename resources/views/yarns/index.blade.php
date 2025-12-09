@extends('layouts.app')

@section('header', 'Manajemen Benang')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header & Action -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8 space-y-4 sm:space-y-0">
        <div>
             <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Stok & Inventaris</h2>
             <p class="text-slate-500 mt-1 text-sm">Monitor ketersediaan bahan baku benang untuk produksi.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('yarns.create') }}" class="group inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-slate-900 rounded-lg hover:bg-slate-800 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
                <svg class="w-5 h-5 mr-2 -ml-1 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Benang
            </a>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Informasi Benang</th>
                        <th class="py-4 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Jenis / Kategori</th>
                        <th class="py-4 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Warna</th>
                        <th class="py-4 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs">Stok Tersedia</th>
                        <th class="py-4 px-6 font-semibold text-slate-600 uppercase tracking-wider text-xs text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse($yarns as $yarn)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="py-4 px-6">
                        <div class="font-bold text-slate-900">{{ $yarn->name }}</div>
                        <div class="text-xs text-slate-500 mt-0.5">Updated: {{ $yarn->updated_at->diffForHumans() }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            {{ $yarn->type }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                             {{-- Simple color dot logic --}}
                            <span class="w-3 h-3 rounded-full border border-slate-200 shadow-sm" 
                                  style="background-color: {{ 
                                    str_contains(strtolower($yarn->color), 'putih') ? '#ffffff' : 
                                    (str_contains(strtolower($yarn->color), 'hitam') ? '#000000' : 
                                    (str_contains(strtolower($yarn->color), 'merah') ? '#ef4444' : 
                                    (str_contains(strtolower($yarn->color), 'biru') ? '#3b82f6' : 
                                    (str_contains(strtolower($yarn->color), 'kuning') ? '#eab308' : 
                                    (str_contains(strtolower($yarn->color), 'hijau') ? '#22c55e' : 
                                    '#cbd5e1'))))) 
                                  }}">
                            </span>
                            <span class="text-slate-700 font-medium">{{ $yarn->color }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                         <div class="flex items-center gap-2">
                            <span class="font-bold {{ $yarn->stock_quantity < 10 ? 'text-red-600' : 'text-slate-700' }}">
                                {{ $yarn->stock_quantity }}
                            </span>
                            <span class="text-slate-400 text-xs">{{ $yarn->unit }}</span>
                            
                            @if($yarn->stock_quantity < 10)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700 uppercase tracking-wide">
                                    Low
                                </span>
                            @endif
                        </div>
                    </td>
                    {{-- Action Buttons --}}
                    <td class="py-4 px-6 text-right">
                        <div class="flex items-center justify-end space-x-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('yarns.edit', $yarn->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Edit Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <button type="button" onclick="confirmDelete({{ $yarn->id }})" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            <form id="delete-form-{{ $yarn->id }}" action="{{ route('yarns.destroy', $yarn->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <h3 class="text-slate-800 font-medium mb-1">Belum ada data benang</h3>
                            <p class="text-slate-500 text-sm mb-4">Mulai dengan menambahkan stok benang baru ke sistem.</p>
                            <a href="{{ route('yarns.create') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium hover:underline">
                                + Tambah Data Pertama
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($yarns->hasPages())
        <div class="bg-white px-6 py-4 border-t border-slate-100">
            {{ $yarns->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Benang?',
            text: "Data stok ini akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-4 py-2 rounded-lg font-medium',
                cancelButton: 'px-4 py-2 rounded-lg font-medium'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
