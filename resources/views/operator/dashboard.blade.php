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
            <!-- Card Header -->
            <div class="flex justify-between items-start mb-4">
                <div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 mb-1">
                        Order #{{ $order->order_number }}
                    </span>
                    <p class="text-xs text-slate-400 font-medium">{{ $order->created_at->diffForHumans() }}</p>
                </div>
                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                    {{ $order->status === 'Completed' ? 'bg-emerald-100 text-emerald-800' : 
                       ($order->status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 
                       ($order->status === 'Pending Check' ? 'bg-orange-100 text-orange-800' : 'bg-slate-100 text-slate-800')) }}">
                    {{ $order->status }}
                </span>
            </div>
            
            <!-- Card Body -->
            <div class="mb-6 flex-1">
                <h3 class="text-xl font-bold text-slate-900 mb-1">{{ $order->items->first()->yarnMaterial->name ?? 'Unknown Item' }}</h3>
                <p class="text-slate-500 text-sm">
                    Target: <span class="font-medium text-slate-700">{{ number_format($order->target_quantity) }} Pcs</span>
                </p>
                <p class="text-xs text-slate-400 mt-2">
                    Assigned by {{ $order->manager->name ?? 'Manager' }}
                </p>
            </div>
            
            <!-- Card Footer (Progress & Actions) -->
            <div class="pt-4 border-t border-slate-100">
                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-slate-500 mb-1 font-medium">
                        <span>Progress</span>
                        <span>{{ number_format($order->produced_quantity) }} / {{ number_format($order->target_quantity) }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $order->target_quantity > 0 ? min(($order->produced_quantity / $order->target_quantity) * 100, 100) : 0 }}%"></div>
                    </div>
                </div>

                <!-- Actions -->
                <form action="{{ route('production.update-status', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    @if($order->status === 'Planned')
                        <button name="status" value="In Progress" class="w-full px-4 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition-colors shadow-lg shadow-slate-200">
                            Start Job
                        </button>
                    @elseif($order->status === 'In Progress')
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('daily-reports.create', ['order_id' => $order->id]) }}" class="flex items-center justify-center px-4 py-2.5 bg-blue-50 text-blue-700 text-sm font-bold rounded-xl hover:bg-blue-100 transition-colors border border-blue-200">
                                + Report
                            </a>
                             <button name="status" value="Pending Check" class="px-4 py-2.5 bg-amber-500 text-white text-sm font-bold rounded-xl hover:bg-amber-600 transition-colors shadow-lg shadow-amber-200">
                                Finish
                            </button>
                        </div>
                    @elseif($order->status === 'Pending Check')
                        <div class="w-full px-4 py-2.5 bg-orange-50 text-orange-700 text-sm font-bold rounded-xl border border-orange-200 text-center cursor-default flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Waiting Verification
                        </div>
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
