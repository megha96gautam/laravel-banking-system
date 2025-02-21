<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SavingAccount extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'account_number',
        'first_name',
        'last_name',
        'date_of_birth',
        'address',
        'balance',
    ];

     // Generate a unique account number
     public static function generateAccountNumber()
     {
         do {
             $accountNumber = 'SA' . mt_rand(1000000000, 9999999999); // Example: SA1234567890
         } while (self::where('account_number', $accountNumber)->exists());
 
         return $accountNumber;
     }

     public function getBalance($currency) {
        return $this->{"balance_" . strtolower($currency)};
    }
    
    public function updateBalance($currency, $amount) {
        $field = "balance_" . strtolower($currency);
        $this->$field += $amount;
        $this->save();
    }
    
}
