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
        Schema::table('schedule_meetings', function (Blueprint $table) {
            $table->date('meeting_end_date')->nullable()->after('is_meeting_completed');
            $table->time('meeting_end_time')->nullable()->after('meeting_end_date');
            $table->text('meeting_end_reason')->nullable()->after('meeting_end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_meetings', function (Blueprint $table) {
            $table->dropColumn('meeting_end_date');
            $table->dropColumn('meeting_end_time');
            $table->dropColumn('meeting_end_reason');
        });
    }
};
