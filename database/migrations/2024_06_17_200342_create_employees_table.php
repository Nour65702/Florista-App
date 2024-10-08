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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->nullable();

            $table->foreignId('branch_id')->constrained('branches')
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->nullable();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->integer('phone')->nullable();
            $table->enum('gender', ['female', 'male'])->default('male');
            $table->enum('employee_type', ['hr', 'accounting', 'provider'])->default('hr');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
