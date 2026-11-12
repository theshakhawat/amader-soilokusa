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
        Schema::create('hero_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('badge')->nullable(); // e.g. ঐতিহ্য ও উন্নয়ন
            $table->string('primary_button_text')->default('আমাদের সম্পর্কে জানুন');
            $table->string('primary_button_link')->default('#about-section');
            $table->string('secondary_button_text')->default('ভিডিও দেখুন');
            $table->string('secondary_button_link')->nullable(); // video url or target
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true); // Active / Inactive on/off
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_banners');
    }
};
