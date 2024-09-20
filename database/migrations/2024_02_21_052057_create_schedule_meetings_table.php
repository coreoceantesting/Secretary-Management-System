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
        Schema::create('schedule_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->nullable()->constrained('agendas');
            $table->foreignId('meeting_id')->nullable()->constrained('meetings');
            $table->string('unique_id')->nullable();
            $table->integer('schedule_meeting_id')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('place')->nullable();
            $table->string('file')->nullable();
            $table->datetime('datetime')->nullable();
            $table->boolean('is_meeting_reschedule')->default(0);
            $table->boolean('is_meeting_completed')->default(0);
            $table->date('meeting_end_date')->nullable();
            $table->time('meeting_end_time')->nullable();
            $table->text('meeting_end_reason')->nullable();
            $table->boolean('is_record_proceeding')->default(0);
            $table->boolean('is_sms_send')->default(0);
            $table->datetime('sms_send_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_meetings');
    }
};
