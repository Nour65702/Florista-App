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
        Schema::create('user_custom_bouquet_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_custom_bouquet_id')->constrained('user_custom_bouquets')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('product_id')->constrained('products')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->integer('quantity');
            $table->json('size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_custom_bouquet_products');
    }
};
