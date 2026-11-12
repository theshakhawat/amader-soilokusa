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
        Schema::create('donation_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('শৈলকুপার উন্নয়নে আপনিও অংশ নিন');
            $table->text('description')->nullable();
            $table->string('button_text')->default('অনুদান দিন এখনই');
            $table->string('button_link')->nullable(); // null or modal action
            $table->string('image')->nullable();
            $table->string('icon')->default('fa-solid fa-hand-holding-heart');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_settings');
    }
};
