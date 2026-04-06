<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium mb-1">Category</label>
                            <select name="category_id" id="category_id" class="w-full px-3 py-2 border {{ $errors->has('category_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
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
                            <input type="number" name="amount" id="amount" step="0.01" class="w-full px-3 py-2 border {{ $errors->has('amount') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded" required value="{{ old('amount', $transaction->amount) }}">
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium mb-1">Description (Optional)</label>
                            <input type="text" name="description" id="description" class="w-full px-3 py-2 border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded" value="{{ old('description', $transaction->description) }}">
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium mb-1">Date</label>
                            <input type="date" name="date" id="date" class="w-full px-3 py-2 border {{ $errors->has('date') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded" required value="{{ old('date', $transaction->date->format('Y-m-d')) }}">
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('transactions.index') }}" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
