<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Keep your study budget on track with quick, student-friendly spending insights.</p>
                <p class="text-sm text-sky-600 dark:text-sky-300 mt-2">Welcome back, {{ auth()->user()?->name ?? 'Student' }}!</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('transactions.create') }}" data-loading="true" class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-full shadow-sm transition duration-300 ease-in-out transform motion-safe:hover:-translate-y-0.5">
                    Add Expense
                </a>
                <a href="{{ route('categories.index') }}" data-loading="true" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-full shadow-sm transition duration-300 ease-in-out transform motion-safe:hover:-translate-y-0.5">
                    Categories
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 rounded-lg px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-3xl bg-gradient-to-r from-sky-500 via-cyan-500 to-indigo-600 text-white shadow-2xl p-6 animate-fade-in-up">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold">Budgeting made simple for students</h3>
                        <p class="mt-2 text-sm sm:text-base text-slate-100/95">See your weekly spending and budget at a glance, with friendly reminders to help manage your pesos.</p>
                    </div>
                    <div class="rounded-full bg-white/15 border border-white/20 px-4 py-2 text-sm text-white">Tip: Save receipts, update your dashboard daily.</div>
                </div>
            </div>

            <div class="rounded-3xl bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-700 p-6 shadow-sm animate-fade-in-up {{ session('first_login') ? 'ring-2 ring-blue-500' : '' }}">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">New here? Start with the tutorial</h3>
                            @if(session('first_login'))
                                <span class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full">First time</span>
                            @endif
                        </div>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Learn the basics of logging expenses, setting your weekly budget, and checking smart spending alerts.</p>
                    </div>
                    <a href="#tutorial-steps" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-full transition duration-200 ease-in-out transform motion-safe:hover:-translate-y-0.5 shadow-sm">View Tutorial</a>
                </div>
            </div>

            <div id="tutorial-steps" class="rounded-3xl bg-slate-50 dark:bg-gray-900 border border-slate-200 dark:border-gray-700 p-6 shadow-sm animate-fade-in-up {{ session('first_login') ? 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/10' : '' }}">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white">How to use this app</h3>
                <ol class="mt-4 space-y-4 text-sm text-slate-600 dark:text-slate-300 list-decimal list-inside">
                    <li><span class="font-semibold text-slate-900 dark:text-white">Add expense</span> — tap <strong>Add Expense</strong> and record your school spending in Philippine pesos.</li>
                    <li><span class="font-semibold text-slate-900 dark:text-white">Set weekly budget</span> — enter your target budget so the app can show your remaining balance.</li>
                    <li><span class="font-semibold text-slate-900 dark:text-white">Check insights</span> — review spending trends and alerts to avoid overspending.</li>
                </ol>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 animate-fade-in-up">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-3xl p-6 transition duration-300 ease-out motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-xl">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Income</div>
                    <div class="text-3xl font-bold text-green-600 mt-2">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">All income recorded.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-3xl p-6 transition duration-300 ease-out motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-xl">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Weekly Spent</div>
                    <div class="text-3xl font-bold text-red-600 mt-2">₱{{ number_format($weeklySpent ?? 0, 2) }}</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">This week only.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-3xl p-6 transition duration-300 ease-out motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-xl">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Weekly Budget</div>
                    <div class="text-3xl font-bold text-blue-600 mt-2">
                        @if($budget)
                            ₱{{ number_format($budget->weekly_budget, 2) }}
                        @else
                            Not set
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Set a weekly spending cap.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-3xl p-6 transition duration-300 ease-out motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-xl">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Remaining Budget</div>
                    <div class="text-3xl font-bold {{ $remainingBudget !== null && $remainingBudget >= 0 ? 'text-green-600' : 'text-gray-400' }} mt-2">
                        @if($remainingBudget !== null)
                            ₱{{ number_format($remainingBudget, 2) }}
                        @else
                            —
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Based on your current weekly plan.</p>
                </div>
            </div>

            @if($budgetWarning || $budgetMessage)
                <div class="bg-yellow-100 dark:bg-yellow-900/20 border border-yellow-300 dark:border-yellow-700 text-yellow-900 dark:text-yellow-100 rounded-3xl p-6 motion-safe:animate-pulse shadow-sm">
                    <div class="font-semibold text-lg">Budget Alert</div>
                    <p class="mt-2">{{ $budgetWarning ?? $budgetMessage }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Spending Charts</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Visualize category and daily spend patterns.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fade-in-up">
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-3xl p-4 transition duration-300 ease-out motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-lg">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Category Breakdown</h4>
                            <canvas id="categoryPieChart" class="w-full h-64"></canvas>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-900 rounded-3xl p-4 transition duration-300 ease-out motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-lg">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Last 7 Days</h4>
                            <canvas id="weeklyLineChart" class="w-full h-64"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Smart Insights</h3>
                    <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                        <p>{{ $spendingInsight ?? 'No spending insights available yet.' }}</p>
                        <p>{{ $weekdayInsight ?? 'Track your spending over the week to see patterns.' }}</p>
                        @if($predictionMessage)
                            <div class="rounded-lg bg-gray-100 dark:bg-gray-900 p-4 text-gray-900 dark:text-gray-100">
                                {{ $predictionMessage }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">Weekly Budget</h4>
                        <form method="POST" action="{{ route('budget.store') }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="weekly_budget" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Weekly Budget</label>
                                    <input id="weekly_budget" name="weekly_budget" type="number" step="0.01" min="0" value="{{ old('weekly_budget', $budget?->weekly_budget) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200 ease-in-out transform motion-safe:hover:-translate-y-0.5 shadow-sm">Save Budget</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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
                                                {{ $transaction->category->type === 'income' ? '+' : '-' }}₱{{ number_format($transaction->amount, 2) }}
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        (function() {
            var categoryLabels = <?php echo json_encode($categorySpending->keys()->all()); ?>;
            var categoryData = <?php echo json_encode($categorySpending->values()->all()); ?>;
            var weeklyLabels = <?php echo json_encode($weeklyLabels); ?>;
            var weeklyData = <?php echo json_encode($weeklyData); ?>;

            var pieCtx = document.getElementById('categoryPieChart');
            if (pieCtx) {
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            data: categoryData,
                            backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6', '#14B8A6'],
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { position: 'bottom', labels: { color: '#9CA3AF' } }
                        }
                    }
                });
            }

            var lineCtx = document.getElementById('weeklyLineChart');
            if (lineCtx) {
                new Chart(lineCtx, {
                    type: 'line',
                    data: {
                        labels: weeklyLabels,
                        datasets: [{
                            label: 'Daily Spend',
                            data: weeklyData,
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.25)',
                            fill: true,
                            tension: 0.3,
                        }]
                    },
                    options: {
                        scales: {
                            x: { ticks: { color: '#9CA3AF' } },
                            y: { ticks: { color: '#9CA3AF' }, beginAtZero: true }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }
        })();
    </script>

    @if(session('first_login'))
        <script>
            setTimeout(() => {
                const tutorialSection = document.getElementById('tutorial-steps');
                if (tutorialSection) {
                    tutorialSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 500);
        </script>
    @endif
</x-app-layout>
