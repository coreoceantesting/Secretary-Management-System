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
        Schema::create('question_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->nullable()->constrained('questions');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_departments');
    }
};
