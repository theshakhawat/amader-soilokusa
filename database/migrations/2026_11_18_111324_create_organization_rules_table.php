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
        Schema::create('organization_rules', function (Blueprint $table) {
            $table->id();
            $table->string('part_no')->comment('e.g. প্রথম ভাগ, দ্বিতীয় ভাগ');
            $table->string('title')->comment('e.g. সংগঠনের পরিচিতি ও লক্ষ্য');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('content');
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_rules');
    }
};
