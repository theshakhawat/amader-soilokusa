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
        Schema::create('topbar_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true); // Whether the topbar header is ON or OFF
            $table->boolean('show_contact')->default(true); // Show location, phone, email
            $table->boolean('show_social')->default(true); // Show social media links
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topbar_settings');
    }
};
