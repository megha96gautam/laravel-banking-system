<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavingAccount;
class SavingAccountController extends Controller
{
    public function index()
    {
        $accounts = SavingAccount::all();
        return view('saving_accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('saving_accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'accounts.*.first_name' => 'required|string|max:255',
            'accounts.*.last_name' => 'required|string|max:255',
            'accounts.*.date_of_birth' => 'required|date',
            'accounts.*.address' => 'required|string|max:500',
        ]);
    
        foreach ($request->accounts as $account) {
            SavingAccount::create([
                'account_number' => SavingAccount::generateAccountNumber(),
                'first_name' => $account['first_name'],
                'last_name' => $account['last_name'],
                'date_of_birth' => $account['date_of_birth'],
                'address' => $account['address'],
                'balance' => 10000, // Initial balance
            ]);
        }
    
        return redirect()->route('admin.accounts')->with('success', 'Saving accounts created successfully.');
    }
    
}
