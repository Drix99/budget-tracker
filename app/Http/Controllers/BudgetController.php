<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'weekly_budget' => 'required|numeric|min:0',
        ]);

        Budget::updateOrCreate(
            ['user_id' => Auth::id()],
            ['weekly_budget' => $validated['weekly_budget']]
        );

        return redirect()->route('dashboard')->with('success', 'Weekly budget saved successfully!');
    }
}
