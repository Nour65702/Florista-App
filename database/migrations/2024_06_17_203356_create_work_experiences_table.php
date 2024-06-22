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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')->constrained('employees')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('work_info_id')->constrained('work_infos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->date('from_date');
            $table->date('to_date');
            $table->string('company');
            $table->string('position');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
