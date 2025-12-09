@extends('layouts.app')

@section('header', 'My Tasks')

@section('content')
<div class="space-y-6">
    <!-- Header Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
             <div class="h-12 w-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
             </div>
             <div>
                 <h2 class="text-lg font-bold text-slate-800">Available Tasks</h2>
                 <p class="text-slate-500 text-sm">You have {{ count($availableOrders) }} orders pending.</p>
             </div>
        </div>
         <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between">
             <div>
                 <h2 class="text-lg font-bold text-slate-800">Need Help?</h2>
                 <p class="text-slate-500 text-sm">Contact your supervisor for issues.</p>
             </div>
             <button onclick="Swal.fire({
                 title: 'Laporkan Masalah',
                 text: 'Silahkan hubungi Supervisor Anda untuk melaporkan masalah teknik atau operasional.',
                 icon: 'info',
                 confirmButtonText: 'Baik, Mengerti',
                 confirmButtonColor: '#0f172a'
             })" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors">
                 Report Issue
             </button>
        </div>
    </div>

    <!-- Task List -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($availableOrders as $order)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow flex flex-col h-full">
            <div class="flex justify-between items-start mb-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                    Order #{{ $order->id }}
                </span>
                <span class="text-xs text-slate-400 font-medium">
                    {{ $order->created_at->diffForHumans() }}
                </span>
            </div>
            
            <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $order->category }}</h3>
            <p class="text-slate-500 text-sm mb-6 flex-1">
                Assigned by <span class="font-medium text-slate-700">{{ $order->manager->name ?? 'Manager' }}</span>
            </p>
            
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <div class="text-xs font-medium text-slate-500">
                    Status: <span class="{{ $order->status === 'In Progress' ? 'text-blue-600' : 'text-slate-700' }}">{{ $order->status }}</span>
                </div>
                <form action="{{ route('production.update-status', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    @if($order->status === 'Planned')
                        <button name="status" value="In Progress" class="px-4 py-2 bg-slate-900 text-white text-sm font-bold rounded-lg hover:bg-slate-800 transition-colors">
                            Start Job
                        </button>
                    @elseif($order->status === 'In Progress')
                         <button name="status" value="Completed" class="px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition-colors">
                            Complete
                        </button>
                    @endif
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-white rounded-2xl border-2 border-dashed border-slate-200">
             <div class="h-16 w-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
             </div>
             <h3 class="text-lg font-bold text-slate-800">All Caught Up!</h3>
             <p class="text-slate-500 mt-1">There are no pending production orders at the moment.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
