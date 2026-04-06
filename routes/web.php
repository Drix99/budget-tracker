<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BudgetController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

Route::get('/', function () {
    /** @var \Illuminate\Auth\AuthManager $auth */
    $auth = auth();
    if ($auth->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->guard('web')->user();
    if (!$user) {
        return redirect('/login');
    }

    $today = \Carbon\Carbon::today();
    $weekStart = $today->copy()->startOfWeek();
    $monthStart = $today->copy()->startOfMonth();

    $totalIncome = $user->transactions()->whereHas('category', function ($q) {
        $q->where('type', 'income');
    })->sum('amount');

    $totalExpenses = $user->transactions()->whereHas('category', function ($q) {
        $q->where('type', 'expense');
    })->sum('amount');

    $weeklyTransactions = $user->transactions()
        ->with('category')
        ->whereHas('category', function ($q) {
            $q->where('type', 'expense');
        })
        ->whereBetween('date', [$weekStart, $today])
        ->get();

    $monthlyTransactions = $user->transactions()
        ->with('category')
        ->whereHas('category', function ($q) {
            $q->where('type', 'expense');
        })
        ->whereBetween('date', [$monthStart, $today])
        ->get();

    $weeklySpent = $weeklyTransactions->sum('amount');
    $monthlySpent = $monthlyTransactions->sum('amount');
    $remainingBudget = null;
    $budgetPercent = null;
    $budgetWarning = null;
    $budgetMessage = null;

    $budget = $user->budget()->latest()->first();
    if ($budget) {
        $remainingBudget = max(0, $budget->weekly_budget - $weeklySpent);
        $budgetPercent = $budget->weekly_budget > 0 ? min(100, ($weeklySpent / $budget->weekly_budget) * 100) : 0;

        if ($budgetPercent >= 80) {
            $budgetWarning = 'Bro... you\'re at 80% already 💀';
        }

        if ($budgetPercent >= 70 && !$budgetWarning) {
            $budgetMessage = 'Careful — you are approaching your weekly budget.';
        }
    }

    $recentTransactions = $user->transactions()
        ->with('category')
        ->latest('date')
        ->limit(5)
        ->get();

    $categorySpending = $weeklyTransactions
        ->groupBy(fn ($tx) => $tx->category->name)
        ->map(fn ($items) => $items->sum('amount'))
        ->sortDesc();

    $topCategory = $categorySpending->keys()->first();
    $topCategoryAmount = $categorySpending->first() ?? 0;
    $topCategoryPercent = $weeklySpent > 0 ? round(($topCategoryAmount / $weeklySpent) * 100) : 0;

    $weeklyLabels = [];
    $weeklyData = [];
    for ($daysAgo = 6; $daysAgo >= 0; $daysAgo--) {
        $date = $today->copy()->subDays($daysAgo);
        $weeklyLabels[] = $date->format('D');
        $weeklyData[] = $user->transactions()
            ->whereHas('category', function ($q) {
                $q->where('type', 'expense');
            })
            ->whereDate('date', $date)
            ->sum('amount');
    }

    $dailyAverage = count($weeklyData) ? round(array_sum($weeklyData) / count($weeklyData), 2) : 0;
    $predictionMessage = null;
    if ($budget && $dailyAverage > 0) {
        $daysLeft = $remainingBudget > 0 ? floor($remainingBudget / $dailyAverage) : 0;
        if ($daysLeft <= 7) {
            $predictionMessage = "You might run out of budget in {$daysLeft} day" . ($daysLeft === 1 ? '' : 's');
        }
    }

    $spendingInsight = null;
    if ($topCategory) {
        $spendingInsight = "You spend {$topCategoryPercent}% on {$topCategory}.";
    }

    $weekdaySums = collect($weeklyData)->values();
    $peakDay = collect($weeklyLabels)->filter(function ($label, $index) use ($weeklyData) {
        return $weeklyData[$index] === max($weeklyData);
    })->first();
    $weekdayInsight = $peakDay ? "Your spending peaks on {$peakDay}." : null;

    return view('dashboard', compact(
        'totalIncome',
        'totalExpenses',
        'weeklySpent',
        'monthlySpent',
        'remainingBudget',
        'budgetPercent',
        'budgetWarning',
        'budgetMessage',
        'budget',
        'recentTransactions',
        'categorySpending',
        'weeklyLabels',
        'weeklyData',
        'dailyAverage',
        'predictionMessage',
        'spendingInsight',
        'weekdayInsight'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('transactions', TransactionController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('budget', [BudgetController::class, 'store'])->name('budget.store');
});

require __DIR__.'/auth.php';
