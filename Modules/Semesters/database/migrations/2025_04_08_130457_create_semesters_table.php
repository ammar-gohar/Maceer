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
        Schema::create('semesters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('requests_start_date');
            $table->date('enrollments_start_date');
            $table->date('enrollments_end_date');
            $table->boolean('is_current')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
