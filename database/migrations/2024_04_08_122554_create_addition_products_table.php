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
        Schema::create('addition_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('addition_id')->constrained('additions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addition_products');
    }
};
