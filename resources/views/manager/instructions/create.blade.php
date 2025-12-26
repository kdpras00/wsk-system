@extends('layouts.app')

@section('header')
<div class="flex items-center gap-4">
    <a href="{{ route('instructions.index') }}" class="p-2 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h2 class="text-xl font-bold text-slate-800 leading-tight">Buat Instruksi Baru</h2>
</div>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8">
            <div class="mb-8">
                <h3 class="text-lg font-bold text-slate-800">Detail Instruksi</h3>
                <p class="text-slate-500 text-sm mt-1">Isi informasi instruksi yang akan disampaikan kepada anggota tim.</p>
            </div>

            <form action="{{ route('instructions.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title Input -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Judul Instruksi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <input type="text" name="title" id="title" required 
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all placeholder:text-slate-400" 
                                placeholder="Contoh: Perubahan Jadwal Produksi Minggu Ini">
                        </div>
                    </div>

                    <!-- Target Role Select -->
                    <div class="col-span-1">
                        <label for="target_role" class="block text-sm font-semibold text-slate-700 mb-2">Target Role <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <select name="target_role" id="target_role" required 
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm appearance-none bg-white transition-all">
                                <option value="" disabled selected>Pilih Role Target</option>
                                <option value="all">Semua Role</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager (Rekah-Rekah)</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="operator">Operator</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-slate-500">Pilih siapa yang dapat melihat instruksi ini.</p>
                    </div>
                </div>
                
                <!-- Description Textarea -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Instruksi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <textarea name="description" id="description" rows="6" required 
                            class="w-full p-4 rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all placeholder:text-slate-400" 
                            placeholder="Jelaskan detail instruksi di sini..."></textarea>
                        
                        <div class="absolute bottom-3 right-3 text-slate-300 pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="text-sm text-blue-800 font-medium">Informasi Penting</p>
                        <p class="text-xs text-blue-600 mt-0.5">Instruksi akan langsung tampil di dashboard pengguna yang dituju setelah disimpan.</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-slate-100">
                    <a href="{{ route('instructions.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-700 text-sm font-semibold hover:bg-slate-50 hover:text-slate-900 transition-all">Batal</a>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 active:bg-blue-800 focus:ring-4 focus:ring-blue-200 transition-all shadow-lg shadow-blue-200">
                        Simpan Instruksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
