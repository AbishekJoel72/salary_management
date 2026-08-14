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
        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salary_period_id');
            $table->unsignedBigInteger('employee_id');
            $table->enum('salary_type', ['daily','monthly',]);
            $table->decimal('base_salary', 10, 2)->default(0);
            $table->decimal('full_days', 5, 1)->default(0);
            $table->decimal('half_days', 5, 1)->default(0);
            $table->decimal('absent_days', 5, 1)->default(0);
            $table->decimal('worked_days', 5, 1)->default(0);
            $table->decimal('gross_salary', 10, 2)->default(0);
            $table->decimal('deduction', 10, 2)->default(0);
            $table->decimal('adjustment', 10, 2)->default(0);
            $table->decimal('net_salary', 10, 2)->default(0);
            $table->enum('status', ['calculated','approved','paid','cancelled',])->default('calculated');
            $table->timestamps();
            $table->foreign('salary_period_id')->references('id')->on('salary_periods')->onDelete('no action');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_details');
    }
};
