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
        Schema::create('goshwaras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->nullable()->constrained('meetings');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->string('name')->nullable();
            $table->string('file')->nullable();
            $table->string('subject')->nullable();
            $table->string('sub_subject')->nullable();
            $table->boolean('is_mayor_selected')->default(0);
            $table->datetime('selected_datetime')->nullable();
            $table->integer('selected_by')->nullable();
            $table->foreignId('sent_by')->nullable()->constrained('users');
            $table->datetime('date')->nullable();
            $table->boolean('is_sent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goshwaras');
    }
};
