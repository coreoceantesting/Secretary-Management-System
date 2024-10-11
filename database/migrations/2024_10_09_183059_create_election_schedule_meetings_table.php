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
        Schema::create('election_schedule_meetings', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->foreignId('election_agenda_id')->nullable()->constrained('election_agendas');
            $table->foreignId('election_meeting_id')->nullable()->constrained('election_meetings');
            $table->string('unique_id')->nullable();
            $table->integer('election_schedule_meeting_id')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('place')->nullable();
            $table->text('reschedule_reason')->nullable();
            $table->datetime('datetime')->nullable();
            $table->boolean('is_meeting_reschedule')->default(0);
            $table->boolean('is_meeting_completed')->default(0);
            $table->boolean('is_meeting_cancel')->default(0);
            $table->text('cancel_remark')->nullable();
            $table->date('cancel_meeting_date')->nullable();
            $table->date('meeting_end_date')->nullable();
            $table->time('meeting_end_time')->nullable();
            $table->text('meeting_end_reason')->nullable();
            $table->boolean('is_record_proceeding')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('election_schedule_meetings');
    }
};
