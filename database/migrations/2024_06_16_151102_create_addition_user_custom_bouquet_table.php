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
        Schema::create('addition_user_custom_bouquet', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_custom_bouquets_id');
            $table->unsignedBigInteger('addition_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('user_custom_bouquets_id')->references('id')->on('user_custom_bouquets')->onDelete('cascade');
            $table->foreign('addition_id')->references('id')->on('additions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addition_user_custom_bouquet');
    }
};
