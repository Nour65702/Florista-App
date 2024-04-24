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
        Schema::create('additions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained('orders')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('type_addition_id')->constrained('type_additions')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additions');
    }
};
