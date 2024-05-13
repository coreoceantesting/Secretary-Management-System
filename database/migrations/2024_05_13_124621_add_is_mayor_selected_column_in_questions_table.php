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
        Schema::table('sub_questions', function (Blueprint $table) {
            $table->boolean('is_mayor_selected')->default(0)->after('response');
            $table->boolean('is_sended')->default(0)->after('is_mayor_selected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_questions', function (Blueprint $table) {
            $table->dropColumn('is_mayor_selected');
            $table->dropColumn('is_sended');
        });
    }
};
