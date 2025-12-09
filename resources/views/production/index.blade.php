@extends('layouts.app')

@section('header', 'Production Orders')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
             <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Production Orders</h2>
             <p class="text-slate-500 mt-1">Kelola order produksi dan alokasi bahan benang.</p>
        </div>
        <a href="{{ route('production.create') }}" class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-200 bg-slate-900 rounded-xl hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            New Order
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Order #</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Manager</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Status</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Start Date</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs">Items</th>
                        <th class="py-4 px-6 font-semibold text-slate-500 uppercase tracking-wider text-xs text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-slate-900">{{ $order->order_number }}</td>
                        <td class="py-4 px-6 text-slate-600 font-medium">{{ $order->manager->name ?? 'Unknown' }}</td>
                        <td class="py-4 px-6">
                            @if($order->status == 'Planned')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">{{ $order->status }}</span>
                            @elseif($order->status == 'In Progress')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">{{ $order->status }}</span>
                            @elseif($order->status == 'Completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">{{ $order->status }}</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-600 font-medium">{{ $order->start_date ? \Carbon\Carbon::parse($order->start_date)->format('d M Y') : '-' }}</td>
                        <td class="py-4 px-6 text-slate-600 font-medium">{{ $order->items->count() }}</td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                {{-- Future: Add view/edit buttons here --}}
                                <span class="text-xs text-slate-400">-</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                            No production orders found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
