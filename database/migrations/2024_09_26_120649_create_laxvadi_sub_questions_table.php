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
        Schema::create('laxvadi_sub_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laxvadi_id')->nullable()->constrained('laxvadis');
            $table->foreignId('member_id')->nullable()->constrained('members');
            $table->string('question');
            $table->string('response')->nullable();
            $table->boolean('is_mayor_selected')->default(0);
            $table->boolean('is_sended')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laxvadi_sub_questions');
    }
};
