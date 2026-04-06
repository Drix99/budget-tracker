<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Transactions') }}
            </h2>
            <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Transaction
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($transactions->isEmpty())
                        <p class="text-gray-500">No transactions found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-semibold">Date</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold">Category</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold">Description</th>
                                        <th class="px-4 py-2 text-right text-sm font-semibold">Amount</th>
                                        <th class="px-4 py-2 text-center text-sm font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-2 text-sm">{{ $transaction->date->format('M d, Y') }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $transaction->category->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $transaction->category->name }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-sm">{{ $transaction->description ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-right {{ $transaction->category->type === 'income' ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                                {{ $transaction->category->type === 'income' ? '+' : '-' }}₱{{ number_format($transaction->amount, 2) }}
                                            </td>
                                            <td class="px-4 py-2 text-center text-sm">
                                                <a href="{{ route('transactions.edit', $transaction) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                                                <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
