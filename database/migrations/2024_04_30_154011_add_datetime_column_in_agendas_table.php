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
        Schema::table('agendas', function (Blueprint $table) {
            $table->foreignId('meeting_id')->after('id')->nullable()->constrained('meetings');
            $table->date('date')->nullable()->after('file');
            $table->time('time')->nullable()->after('date');
            $table->string('place')->nullable()->after('time');
            $table->string('pdf')->nullable()->after('place');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('meeting_id');
            $table->dropColumn('date');
            $table->dropColumn('time');
            $table->dropColumn('place');
        });
    }
};
