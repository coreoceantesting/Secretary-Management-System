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
        Schema::create('tharav_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tharav_id')->constrained('tharavs');
            $table->foreignId('department_id')->constrained('departments');
            $table->text('question');
            $table->integer('question_by');
            $table->timestamp('question_time');
            $table->text('answer')->nullable();
            $table->integer('answer_by')->nullable();
            $table->timestamp('answer_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tharav_questions');
    }
};
