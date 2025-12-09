@extends('layouts.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Create Production Order</h2>
            <form action="{{ route('production.store') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    There were errors with your submission:
                                </p>
                                <ul class="mt-1 list-disc list-inside text-sm text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="order_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Order Number</label>
                        <input type="text" name="order_number" id="order_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required value="{{ old('order_number') }}">
                        @error('order_number')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="target_quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Target Quantity (Total Pcs)</label>
                        <input type="number" name="target_quantity" id="target_quantity" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required value="{{ old('target_quantity') }}">
                        @error('target_quantity')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('start_date') }}">
                    </div>
                    <div>
                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date (Planned)</label>
                        <input type="date" name="end_date" id="end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('end_date') }}">
                    </div>
                </div>
                
                <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Production Items</h3>
                <div id="items-container">
                    <!-- Dynamic Items will be appended here -->
                    <div class="grid gap-4 mb-4 sm:grid-cols-3 item-row" data-index="0">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Yarn Material</label>
                            <select name="items[0][yarn_material_id]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" disabled selected>Select Yarn</option>
                                @foreach($yarns as $yarn)
                                    <option value="{{ $yarn->id }}">{{ $yarn->name }} ({{ $yarn->type }} - {{ $yarn->color }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Planned Quantity</label>
                            <input type="number" name="items[0][planned_quantity]" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0.00" required>
                        </div>
                        <div class="flex items-end">
                            <button type="button" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900 remove-item disabled:opacity-50" disabled>Remove</button>
                        </div>
                    </div>
                </div>
                
                <button type="button" id="add-item" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Add Another Item</button>
                
                <div class="mt-6">
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Create Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemIndex = 1;
        const container = document.getElementById('items-container');
        const addButton = document.getElementById('add-item');
        
        addButton.addEventListener('click', function() {
            const firstRow = container.querySelector('.item-row');
            const newRow = firstRow.cloneNode(true);
            
            newRow.setAttribute('data-index', itemIndex);
            
            // Update inputs
            const selects = newRow.querySelectorAll('select');
            selects.forEach(select => {
                select.name = `items[${itemIndex}][yarn_material_id]`;
                select.value = "";
            });
            
            const inputs = newRow.querySelectorAll('input');
            inputs.forEach(input => {
                input.name = `items[${itemIndex}][planned_quantity]`;
                input.value = "";
            });
            
            // Enable remove button
            const removeBtn = newRow.querySelector('.remove-item');
            removeBtn.disabled = false;
            removeBtn.addEventListener('click', function() {
                newRow.remove();
            });
            
            container.appendChild(newRow);
            itemIndex++;
        });
    });
</script>
@endsection
