<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SavingAccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransactionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transfer', [TransactionController::class, 'transferFunds'])->name('transfer.form');

   
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/saving-accounts', [SavingAccountController::class, 'index'])->name('saving_accounts.index');
    Route::get('/saving-accounts/create', [SavingAccountController::class, 'create'])->name('saving_accounts.create');
    Route::post('/saving-accounts', [SavingAccountController::class, 'store'])->name('saving_accounts.store');


    Route::get('/admin/accounts', [AdminController::class, 'listAccounts'])->name('admin.accounts');

});

require __DIR__.'/auth.php';
