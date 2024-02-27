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
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('meeting_id')->nullable()->constrained('meetings');
            $table->string('file')->nullable();
            $table->text('remark')->nullable();
            $table->string('sent_by')->nullable();
            $table->date('date')->nullable();
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
