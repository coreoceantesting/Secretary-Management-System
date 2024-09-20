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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ward_id')->nullable()->constrained('wards');
            $table->string('name', 100);
            $table->string('contact_number', 13)->nullable();
            $table->string('email', 150);
            $table->string('political_party', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('designation')->nullable();
            $table->string('photo')->nullable();
            $table->string('alternate_number')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
