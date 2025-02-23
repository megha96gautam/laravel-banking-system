<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saving_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->unique(); // Unique Account Number
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->text('address');
            $table->decimal('balance', 10, 2)->default(10000); // Initial balance of 10,000 USD
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saving_accounts');
    }
};
