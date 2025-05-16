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
            $table->uuid('id')->primary()->unique();
            $table->uuid('course_id');
            $table->uuid('student_id');
            $table->float('midterm_exam', 1)->nullable();
            $table->float('final_exam', 1)->nullable();
            $table->float('total_mark', 1)->nullable();
            $table->float('total_mark_percentage', 2)->nullable();
            $table->float('quality_points', 2)->nullable();
            $table->float('final_gpa', 2)->nullable();
            $table->uuid('grade_id')->nullable();
            $table->boolean('is_approved')->nullable();
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
