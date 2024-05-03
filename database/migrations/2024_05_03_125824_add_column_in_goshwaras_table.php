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
            $table->boolean('is_mayor_selected')->default(0)->after('subject');
            $table->datetime('selected_datetime')->nullable()->after('is_mayor_selected');
            $table->integer('selected_by')->nullable()->after('selected_datetime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goshwaras', function (Blueprint $table) {
            $table->dropColumn('is_mayor_selected');
            $table->dropColumn('selected_datetime');
            $table->dropColumn('selected_by');
        });
    }
};
