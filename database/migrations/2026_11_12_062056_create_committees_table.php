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
        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // e.g. কার্যনির্বাহী কমিটি
            $table->string('session_duration');          // e.g. ২০২৬-২০২৮ বা 2026-2028
            $table->string('subtitle')->nullable();      // e.g. আগামীর শৈলকুপা
            $table->string('image')->nullable();         // Photo path
            $table->text('description')->nullable();     // Additional details / members list
            $table->boolean('is_active')->default(true); // Active / Current committee
            $table->integer('order')->default(0);        // Sorting
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committees');
    }
};
