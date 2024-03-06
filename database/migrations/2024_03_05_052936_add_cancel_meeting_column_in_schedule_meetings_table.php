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
            $table->boolean('is_meeting_cancel')->after('is_meeting_completed')->default(0);
            $table->date('cancel_meeting_date')->after('is_meeting_cancel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_meetings', function (Blueprint $table) {
            $table->dropColumn('is_meeting_cancel');
            $table->dropColumn('cancel_meeting_date');
        });
    }
};
