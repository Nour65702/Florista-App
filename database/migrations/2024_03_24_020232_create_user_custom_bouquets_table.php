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
        Schema::create('user_custom_bouquets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('design_id')->constrained('designs')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('color_id')->constrained('colors')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('name');
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_custom_bouquets');
    }
};
