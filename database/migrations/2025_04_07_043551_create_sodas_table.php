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
        Schema::create('sodas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->unique(); // one-to-one relationship with a product
            $table->string('soda_name');
            $table->string('brand');
            $table->integer('size_ml');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sodas');
    }
};
