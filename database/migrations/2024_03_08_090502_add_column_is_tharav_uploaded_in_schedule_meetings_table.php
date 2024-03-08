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
            $table->boolean('is_tharav_uploaded')->default(0)->after('is_record_proceeding');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_meetings', function (Blueprint $table) {
            $table->dropColumn('is_tharav_uploaded');
        });
    }
};
