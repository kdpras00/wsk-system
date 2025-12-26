@extends('layouts.app')

@section('header', 'Kelola Instruksi')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <h2 class="text-lg font-bold text-slate-800">Daftar Instruksi</h2>
        <a href="{{ route('instructions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Instruksi Baru
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold">Judul</th>
                    <th scope="col" class="px-6 py-4 font-bold">Target Role</th>
                    <th scope="col" class="px-6 py-4 font-bold">Dibuat Pada</th>
                    <th scope="col" class="px-6 py-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($instructions as $instruction)
                    <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            {{ $instruction->title }}
                            <div class="text-xs text-slate-500 font-normal mt-1 truncate max-w-xs">{{ $instruction->description }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $instruction->target_role === 'all' ? 'bg-purple-100 text-purple-800' : 
                                   ($instruction->target_role === 'operator' ? 'bg-blue-100 text-blue-800' : 
                                   ($instruction->target_role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800')) }}">
                                {{ ucfirst($instruction->target_role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $instruction->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('instructions.edit', $instruction) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('instructions.destroy', $instruction) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus instruksi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <span class="block mt-2 font-medium">Belum ada instruksi.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
