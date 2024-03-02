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
        Schema::create('suplimentry_agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_meeting_id')->nullable()->constrained('schedule_meetings');
            $table->string('name')->nullable();
            $table->string('file')->nullable();
            $table->boolean('is_meeting_completed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suplimentry_agendas');
    }
};
