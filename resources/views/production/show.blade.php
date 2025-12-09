@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Order #{{ $order->order_number }}</h1>
            <p class="text-slate-500">Created on {{ $order->created_at->format('d M Y') }} by {{ $order->manager->name ?? 'Unknown' }}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-sm font-semibold
                {{ $order->status === 'Completed' ? 'bg-emerald-100 text-emerald-800' : 
                   ($order->status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 
                   ($order->status === 'Pending Check' ? 'bg-orange-100 text-orange-800' : 'bg-slate-100 text-slate-800')) }}">
                {{ $order->status }}
            </span>
             {{-- Manager Actions --}}
             @if(Auth::user()->role !== 'operator' && $order->status === 'Pending Check')
                <form id="verify-order-show-{{ $order->id }}" action="{{ route('production.update-status', $order->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Completed">
                    <button onclick="confirmFormSubmission(event, 'verify-order-show-{{ $order->id }}', 'Verifikasi Order Selesai?', 'Tindakan ini akan menyelesaikan order dan menambah stok barang jadi.', 'Ya, Verifikasi!')" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-bold transition-colors">
                        Verify & Complete
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Progress Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Production Progress</h3>
        <div class="mb-2 flex justify-between text-sm font-medium text-slate-600">
            <span>Produced: {{ number_format($order->produced_quantity) }}</span>
            <span>Target: {{ number_format($order->target_quantity) }}</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-4 mb-4">
            <div class="bg-blue-600 h-4 rounded-full transition-all duration-500" style="width: {{ $order->target_quantity > 0 ? min(($order->produced_quantity / $order->target_quantity) * 100, 100) : 0 }}%"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="bg-slate-50 p-4 rounded-lg">
                <p class="text-xs text-slate-500 uppercase font-bold">Start Date</p>
                <p class="text-slate-900 font-medium">{{ $order->start_date ? \Carbon\Carbon::parse($order->start_date)->format('d M Y') : '-' }}</p>
            </div>
            <div class="bg-slate-50 p-4 rounded-lg">
                <p class="text-xs text-slate-500 uppercase font-bold">End Date (Planned)</p>
                <p class="text-slate-900 font-medium">{{ $order->end_date ? \Carbon\Carbon::parse($order->end_date)->format('d M Y') : '-' }}</p>
            </div>
             <div class="bg-slate-50 p-4 rounded-lg">
                <p class="text-xs text-slate-500 uppercase font-bold">Planned Item</p>
                 @foreach($order->items as $item)
                    <p class="text-slate-900 font-medium">{{ $item->yarnMaterial->name ?? 'Unknown' }} ({{ $item->planned_quantity + 0 }})</p>
                 @endforeach
            </div>
        </div>
    </div>

    <!-- Daily Reports History -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800">Riwayat Laporan Harian</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Operator</th>
                        <th class="px-6 py-3">Mesin</th>
                        <th class="px-6 py-3">Total Output</th>
                        <th class="px-6 py-3">Status</th>
                         <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($order->productionReports as $report)
                    <tr class="bg-white hover:bg-slate-50">
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($report->production_date)->format('d M Y') }}</td>
                        <td class="px-6 py-4">{{ $report->user->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $report->machine_name }}</td>
                        <td class="px-6 py-4 font-bold">{{ $report->details->sum('pcs_count') }}</td>
                         <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $report->status === 'Approved' ? 'bg-green-100 text-green-800' : 
                                   ($report->status === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $report->status }}
                            </span>
                        </td>
                         <td class="px-6 py-4">
                            <a href="{{ route('daily-reports.show', $report->id) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada laporan produksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
