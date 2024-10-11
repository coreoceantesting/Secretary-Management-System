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
        Schema::create('election_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_schedule_meeting_id')->nullable()->constrained('election_schedule_meetings');
            $table->foreignId('election_meeting_id')->nullable()->constrained('election_meetings');
            $table->foreignId('member_id')->nullable()->constrained('members');
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('election_attendances');
    }
};
