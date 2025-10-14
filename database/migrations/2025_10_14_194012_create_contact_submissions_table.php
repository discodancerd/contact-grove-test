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
        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 255);
            $table->string('email', length: 255);
            $table->string('subject', length: 255);
            $table->string('message', length: 2048);
            $table->string('ip', length: 46);
            $table->string('ua', length: 2048);
            $table->string('attachment', length: 36)->nullable(); // UUID file name
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
    }
};
