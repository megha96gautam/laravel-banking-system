<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SavingAccount;


class AdminController extends Controller
{
    public function listAccounts(Request $request)
    {
        $query = SavingAccount::query();

        // Search filters
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('first_name', 'LIKE', "%{$search}%")
                  ->orwhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('date_of_birth', 'LIKE', "%{$search}%")
                  ->orWhere('account_number', 'LIKE', "%{$search}%");
        }

     

        $minBalance = $request->input('min_balance', 0); // Default min balance: 0
        $maxBalance = $request->input('max_balance', 1000000); // Default max balance: 1M


            if ($minBalance !== null) {
                $query->where('balance', '>=', $minBalance);
            }

            if ($maxBalance !== null) {
                $query->where('balance', '<=', $maxBalance);
            }

        $users = $query->paginate(10); // Pagination
  
        return view('admin.accounts', compact('users'));
    }
}
