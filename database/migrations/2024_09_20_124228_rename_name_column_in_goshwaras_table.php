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
            $table->renameColumn('name', 'outward_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goshwaras', function (Blueprint $table) {
            $table->renameColumn('outward_no', 'name');
        });
    }
};
