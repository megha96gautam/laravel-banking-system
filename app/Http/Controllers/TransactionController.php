<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Services\ExchangeRateService;


class TransactionController extends Controller
{
   
        public function index() {
            $transactions = Auth::user()->transactions()->orderBy('transaction_date', 'desc')->paginate(10);
            return view('transactions.index', compact('transactions'));
        }

        public function transferFunds(Request $request, ExchangeRateService $exchangeRateService) {
            $request->validate([
                'receiver_id' => 'required|exists:users,id',
                'amount' => 'required|numeric|min:1',
                'currency' => 'required|in:usd,gbp,eur',
            ]);
    
            $sender = Auth::user();
            $receiver = User::findOrFail($request->receiver_id);
            $amount = $request->amount;
            $currency = strtolower($request->currency);
    
            // Check sender's balance
            if ($sender->getBalance($currency) < $amount) {
                return back()->with('error', 'Insufficient balance.');
            }
    
            DB::beginTransaction();
            try {
                // Convert currency if receiver uses a different one
                $receiverCurrency = 'usd'; // Assume default is USD
                if ($receiver->balance_gbp > 0) $receiverCurrency = 'gbp';
                if ($receiver->balance_eur > 0) $receiverCurrency = 'eur';
    
                if ($currency !== $receiverCurrency) {
                    $conversionRate = $exchangeRateService->getRate($currency, $receiverCurrency);
                    if (!$conversionRate) {
                        DB::rollBack();
                        return back()->with('error', 'Currency conversion failed.');
                    }
                    $convertedAmount = $amount * $conversionRate;
                } else {
                    $convertedAmount = $amount;
                }
    
                // Deduct from sender
                $sender->updateBalance($currency, -$amount);
                Transaction::create([
                    'user_id' => $sender->id,
                    'type' => 'debit',
                    'amount' => $amount,
                    'description' => "Transfer to {$receiver->name} ({$currency})",
                ]);
    
                // Credit to receiver
                $receiver->updateBalance($receiverCurrency, $convertedAmount);
                Transaction::create([
                    'user_id' => $receiver->id,
                    'type' => 'credit',
                    'amount' => $convertedAmount,
                    'description' => "Received from {$sender->name} ({$receiverCurrency})",
                ]);
    
                DB::commit();
                return back()->with('success', 'Transfer successful!');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Transaction failed. Please try again.');
            }
        }
    }