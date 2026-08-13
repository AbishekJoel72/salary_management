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
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('designation_id');
            $table->string('employee_code')->unique();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->enum('employee_type', ['daily', 'monthly']);
            $table->decimal('daily_rate', 10, 2)->nullable();
            $table->decimal('monthly_salary', 10, 2)->nullable();
            $table->date('joining_date')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamps();

            $table->softDeletes();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('no action');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('no action');
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
