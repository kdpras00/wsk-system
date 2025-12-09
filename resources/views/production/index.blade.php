@extends('layouts.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
             <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-auto">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Production Orders</h2>
                </div>
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <a href="{{ route('production.create') }}" class="text-sm bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-slate-800 transition-colors">
                        + New Order
                    </a>
                </div>
            </div>
             <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Order #</th>
                            <th scope="col" class="px-4 py-3">Manager</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3">Start Date</th>
                             <th scope="col" class="px-4 py-3">Items</th>
                            <th scope="col" class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $order->order_number }}</td>
                            <td class="px-4 py-3">{{ $order->manager->name ?? 'Unknown' }}</td>
                            <td class="px-4 py-3">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $order->status }}</span>
                            </td>
                            <td class="px-4 py-3">{{ $order->start_date ? \Carbon\Carbon::parse($order->start_date)->format('d M Y') : '-' }}</td>
                            <td class="px-4 py-3">{{ $order->items->count() }}</td>
                            <td class="px-4 py-3 flex items-center justify-end">
                                {{-- <a href="{{ route('production.show', $order->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-3">View</a> --}}
                                {{-- <a href="{{ route('production.edit', $order->id) }}" class="font-medium text-green-600 dark:text-green-500 hover:underline mr-3">Edit</a> --}}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">No production orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
             </div>
        </div>
    </div>
</section>
@endsection
