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
        Schema::create('cart_user_custom_bouquets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_custom_bouquet_id')->constrained('user_custom_bouquets')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_custom_bouquets');
    }
};
