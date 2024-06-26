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
        Schema::table('goshwaras', function (Blueprint $table) {
            $table->foreignId('meeting_id')->after('id')->nullable()->constrained('meetings');
            $table->string('subject')->nullable()->after('remark');
            $table->dropColumn('remark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goshwaras', function (Blueprint $table) {
            $table->dropConstrainedForeignId('meeting_id');
            $table->dropColumn('subject');
            $table->text('remark')->nullable()->after('file');
        });
    }
};
