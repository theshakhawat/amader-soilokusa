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
        if (!Schema::hasTable('font_settings')) {
            Schema::create('font_settings', function (Blueprint $table) {
                $table->id();
                $table->string('admin_font_family')->default('SolaimanLipi');
                $table->string('admin_font_size')->default('16px');
                $table->string('admin_font_weight')->default('700');
                $table->string('admin_font_style')->default('normal');

                $table->string('website_font_family')->default('SolaimanLipi');
                $table->string('website_font_size')->default('17px');
                $table->string('website_font_weight')->default('700');
                $table->string('website_font_style')->default('normal');

                $table->string('navbar_font_family')->nullable();
                $table->string('navbar_font_size')->nullable();
                $table->string('navbar_font_weight')->nullable();
                $table->string('navbar_font_style')->nullable();

                $table->string('banner_font_family')->nullable();
                $table->string('banner_font_size')->nullable();
                $table->string('banner_font_weight')->nullable();
                $table->string('banner_font_style')->nullable();

                $table->string('content_font_family')->nullable();
                $table->string('content_font_size')->nullable();
                $table->string('content_font_weight')->nullable();
                $table->string('content_font_style')->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('font_settings');
    }
};
