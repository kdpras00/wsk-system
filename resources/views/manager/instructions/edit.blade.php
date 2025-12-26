@extends('layouts.app')

@section('header')
<div class="flex items-center gap-4">
    <a href="{{ route('instructions.index') }}" class="p-2 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h2 class="text-xl font-bold text-slate-800 leading-tight">Edit Instruksi</h2>
</div>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8">
            <div class="mb-8 border-b border-slate-100 pb-6 flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Update Informasi</h3>
                    <p class="text-slate-500 text-sm mt-1">Perbarui detail instruksi yang sudah ada.</p>
                </div>
                <div class="px-3 py-1 bg-slate-100 rounded-full text-xs font-medium text-slate-600 border border-slate-200">
                    ID: #{{ $instruction->id }}
                </div>
            </div>

            <form action="{{ route('instructions.update', $instruction) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title Input -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Judul Instruksi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <input type="text" name="title" id="title" value="{{ old('title', $instruction->title) }}" required 
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all font-medium text-slate-700">
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
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm appearance-none bg-white transition-all text-slate-700">
                                <option value="all" {{ $instruction->target_role == 'all' ? 'selected' : '' }}>Semua Role</option>
                                <option value="admin" {{ $instruction->target_role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="manager" {{ $instruction->target_role == 'manager' ? 'selected' : '' }}>Manager</option>
                                <option value="supervisor" {{ $instruction->target_role == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                <option value="operator" {{ $instruction->target_role == 'operator' ? 'selected' : '' }}>Operator</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Description Textarea -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Instruksi <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="6" required 
                        class="w-full p-4 rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all text-slate-700 leading-relaxed">{{ old('description', $instruction->description) }}</textarea>
                </div>

                <!-- Info Alert -->
                 <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <p class="text-sm text-amber-800 font-medium">Perhatian</p>
                        <p class="text-xs text-amber-600 mt-0.5">Mengubah instruksi akan memperbarui tampilan di dashboard pengguna terkait secara real-time.</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-slate-100">
                    <a href="{{ route('instructions.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-700 text-sm font-semibold hover:bg-slate-50 hover:text-slate-900 transition-all">Batal</a>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 active:bg-blue-800 focus:ring-4 focus:ring-blue-200 transition-all shadow-lg shadow-blue-200">
                        Update Instruksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
