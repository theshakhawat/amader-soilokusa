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
        Schema::create('president_messages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('সভাপতির বাণী');
            $table->string('name')->default('মোঃ আব্দুল করিম');
            $table->string('designation')->default('সভাপতি, আগামীর শৈলকুপা');
            $table->text('quote'); // Quote shown on homepage card
            $table->longText('message')->nullable(); // Detailed message (rich text) for modal or page
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('president_messages');
    }
};
