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
            $table->uuid('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('level')->default('freshman');
            $table->float('gpa', 2)->default(0.00);
            $table->integer('elected_earned_credits')->default(0);
            $table->integer('core_earned_credits')->default(0);
            $table->integer('total_earned_credits')->default(0);
            $table->integer('maximum_credits_to_enroll')->default(18);
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
