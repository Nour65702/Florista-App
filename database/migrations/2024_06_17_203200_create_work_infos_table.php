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
        Schema::create('work_infos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')->constrained('employees')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('provider_id')->constrained('providers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('department_id')->constrained('departments')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('country_id')->constrained('countries')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('city');

            $table->string('business_email')->unique();
            $table->integer('business_number')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_infos');
    }
};
