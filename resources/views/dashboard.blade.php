<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Transaction
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Income</div>
                    <div class="text-3xl font-bold text-green-600 mt-2">
                        ${{ number_format($totalIncome ?? 0, 2) }}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Expenses</div>
                    <div class="text-3xl font-bold text-red-600 mt-2">
                        ${{ number_format($totalExpenses ?? 0, 2) }}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Balance</div>
                    <div class="text-3xl font-bold {{ (($totalIncome ?? 0) - ($totalExpenses ?? 0)) >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2">
                        ${{ number_format(($totalIncome ?? 0) - ($totalExpenses ?? 0), 2) }}
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Recent Transactions</h3>

                    @if(isset($recentTransactions) && $recentTransactions->isEmpty())
                        <p class="text-gray-500">No transactions yet. <a href="{{ route('transactions.create') }}" class="text-blue-600 hover:underline">Create one</a>.</p>
                    @elseif(isset($recentTransactions) && $recentTransactions->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-semibold">Date</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold">Category</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold">Description</th>
                                        <th class="px-4 py-2 text-right text-sm font-semibold">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $transaction)
                                        <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-2 text-sm">{{ $transaction->date->format('M d, Y') }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $transaction->category->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $transaction->category->name }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-sm">{{ $transaction->description ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-right {{ $transaction->category->type === 'income' ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                                {{ $transaction->category->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No transactions found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
