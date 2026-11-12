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
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('আমাদের সম্পর্কে');
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable(); // Home page short summary
            $table->longText('description')->nullable(); // Detailed rich text HTML content
            $table->string('image')->nullable();
            $table->string('button_text')->default('বিস্তারিত পড়ুন');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
