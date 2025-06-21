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
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('level_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->float('gpa', 2)->default(0.00);
            $table->integer('unversity_elected_earned_credits')->default(0);
            $table->integer('faculty_elected_earned_credits')->default(0);
            $table->integer('program_elected_earned_credits')->default(0);
            $table->integer('core_earned_credits')->default(0);
            $table->integer('total_earned_credits')->default(0);
            $table->integer('maximum_credits_to_enroll')->default(18);
            $table->foreignUuid('guide_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
