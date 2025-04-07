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
        Schema::create('canteen_transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('credit', 10, 2)->default(0);
            $table->decimal('debit', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('transaction_type');
            $table->string('username');
            $table->boolean('inside_transaction')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canteen_transactions');
    }
};
