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
            $table->text('question')->change();
            $table->text('response')->change();
            $table->datetime('response_datetime')->after('response')->nullable();
            $table->datetime('is_mayor_selected_datetime')->after('is_mayor_selected')->nullable();
            $table->datetime('is_sended_datetime')->after('is_sended')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_questions', function (Blueprint $table) {
            $table->string('question')->change();
            $table->string('response')->change();
            $table->dropColumn('response_datetime');
            $table->dropColumn('is_mayor_selected_datetime');
            $table->dropColumn('is_sended_datetime');
        });
    }
};
