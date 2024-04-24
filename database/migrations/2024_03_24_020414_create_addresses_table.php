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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('order_id')->constrained('orders')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('city');

            $table->foreignId('country_id')->constrained('countries')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->text('line_one');
            $table->text('line_two');
            $table->text('street');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
