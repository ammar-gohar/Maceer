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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('midterm_exam', 1)->nullable();
            $table->float('final_exam', 1)->nullable();
            $table->float('total_mark', 1)->nullable();
            $table->float('totla_mark_percentage', 2)->nullable();
            $table->foreignId('grade_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('year');
            $table->enum('semester', [1, 2]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
