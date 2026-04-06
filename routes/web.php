<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->guard('web')->user();
    if (!$user) {
        return redirect('/login');
    }
    
    /** @var \App\Models\User $user */
    $totalIncome = $user->transactions()->whereHas('category', function ($q) {
        $q->where('type', 'income');
    })->sum('amount');
    
    $totalExpenses = $user->transactions()->whereHas('category', function ($q) {
        $q->where('type', 'expense');
    })->sum('amount');
    
    $recentTransactions = $user->transactions()
        ->with('category')
        ->latest('date')
        ->limit(5)
        ->get();

    return view('dashboard', compact('totalIncome', 'totalExpenses', 'recentTransactions'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('transactions', TransactionController::class);
    Route::resource('categories', CategoryController::class);
});

require __DIR__.'/auth.php';
