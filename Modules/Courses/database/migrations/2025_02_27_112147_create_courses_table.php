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
        Schema::create('courses', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('name_ar')->unique();
            $table->integer('min_credits')->default(0);
            $table->integer('credits');
            $table->enum('requirement', ['university', 'faculty', 'specialization']);
            $table->enum('type', ['core', 'elected']);
            $table->integer('full_mark')->default(100);
            $table->string('level_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
