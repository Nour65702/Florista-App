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
        Schema::create('user_custom_bouquet_product_additions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bouquet_product_id')
                  ->constrained('user_custom_bouquet_products')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('addition_id')
                  ->constrained('additions')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->integer('quantity');
            $table->timestamps();
                 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_custom_bouquet_product_additions');
    }
};
