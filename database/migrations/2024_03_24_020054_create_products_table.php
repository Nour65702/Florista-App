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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('collection_id')
                ->constrained('collections')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->longText('description');
            $table->json('size');
            $table->integer('rate')->nullable();
            $table->integer('min_level')->default(0);
         

            $table->boolean('is_active')->default(true);
            $table->boolean('in_stock')->default(true);
            $table->boolean('on_sale')->default(false);
            $table->timestamp('triggered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
