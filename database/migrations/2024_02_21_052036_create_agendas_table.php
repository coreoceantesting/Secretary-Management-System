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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->nullable()->constrained('meetings');
            $table->string('name');
            $table->string('file')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('place')->nullable();
            $table->string('pdf')->nullable();
            $table->boolean('is_meeting_schedule')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
