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
        Schema::table('members', function (Blueprint $table) {
            $table->string('aadhar')->nullable()->after('alternate_number');
            $table->string('pancard')->nullable()->after('aadhar');
            $table->string('bank_details')->nullable()->after('pancard');
            $table->string('cancel_cheque')->nullable()->after('bank_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('aadhar');
            $table->dropColumn('pancard');
            $table->dropColumn('bank_details');
            $table->dropColumn('cancel_cheque');
        });
    }
};
