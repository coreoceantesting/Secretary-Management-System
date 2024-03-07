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
            $table->text('cancel_remark')->nullable()->after('is_meeting_cancel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_meetings', function (Blueprint $table) {
            $table->dropColumn('cancel_remark');
        });
    }
};
