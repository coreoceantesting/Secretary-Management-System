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
        Schema::table('suplimentry_agendas', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('subject')->nullable()->after('schedule_meeting_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suplimentry_agendas', function (Blueprint $table) {
            $table->string('name')->nullable()->after('schedule_meeting_id');
            $table->dropColumn('subject');
        });
    }
};
