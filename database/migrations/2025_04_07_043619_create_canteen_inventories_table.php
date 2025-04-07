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
        Schema::create('canteen_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('show_id');     // References canteen's show table
            $table->unsignedBigInteger('product_id');    // References the products table
            $table->integer('initial_stock');            // Starting stock for the period/show
            $table->integer('refill_stock')->nullable(); // Stock refilled before the show, if any
            $table->integer('final_stock');              // Stock at the end of the show period
            $table->timestamps();

            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canteen_inventories');
    }
};
