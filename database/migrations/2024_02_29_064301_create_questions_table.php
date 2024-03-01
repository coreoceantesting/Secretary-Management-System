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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->nullable()->constrained('meetings');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('schedule_meeting_id')->nullable()->constrained('schedule_meetings');
            $table->string('question')->nullable();
            $table->string('question_file')->nullable();
            $table->text('description')->nullable();
            $table->string('response_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
