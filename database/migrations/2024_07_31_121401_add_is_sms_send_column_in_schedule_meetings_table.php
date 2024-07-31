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
            $table->boolean('is_sms_send')->after('cancel_meeting_date')->default(0);
            $table->datetime('sms_send_time')->after('is_sms_send')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_meetings', function (Blueprint $table) {
            //
        });
    }
};
