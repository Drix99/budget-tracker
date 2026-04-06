<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl p-6 mb-6 animate-fade-in-up">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Log a study expense</h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Capture your school spending in Philippine pesos and keep your budget on track.</p>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-3xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium mb-1">Category</label>
                            <select name="category_id" id="category_id" class="w-full px-3 py-2 rounded bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100 shadow-sm transition duration-200 ease-in-out focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500 {{ $errors->has('category_id') ? 'border border-red-500' : 'border border-gray-300 dark:border-gray-600' }}" required>
                                <option value="" class="text-gray-500">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} class="text-gray-900 dark:text-gray-100">
                                        {{ $category->name }} ({{ ucfirst($category->type) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium mb-1">Amount</label>
                            <input type="number" name="amount" id="amount" step="0.01" placeholder="₱0.00" class="w-full px-3 py-2 rounded bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100 shadow-sm transition duration-200 ease-in-out focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500 {{ $errors->has('amount') ? 'border border-red-500' : 'border border-gray-300 dark:border-gray-600' }}" required value="{{ old('amount') }}">
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium mb-1">Description (Optional)</label>
                            <input type="text" name="description" id="description" placeholder="Enter description" class="w-full px-3 py-2 rounded bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100 shadow-sm transition duration-200 ease-in-out focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500 {{ $errors->has('description') ? 'border border-red-500' : 'border border-gray-300 dark:border-gray-600' }}" value="{{ old('description') }}">
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium mb-1">Date</label>
                            <input type="date" name="date" id="date" class="w-full px-3 py-2 rounded bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100 shadow-sm transition duration-200 ease-in-out focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500 {{ $errors->has('date') ? 'border border-red-500' : 'border border-gray-300 dark:border-gray-600' }}" required value="{{ old('date', now()->format('Y-m-d')) }}">
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('transactions.index') }}" class="inline-flex items-center justify-center bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition duration-200 ease-in-out transform motion-safe:hover:-translate-y-0.5">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200 ease-in-out transform motion-safe:hover:-translate-y-0.5 shadow-sm">
                                Create Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
