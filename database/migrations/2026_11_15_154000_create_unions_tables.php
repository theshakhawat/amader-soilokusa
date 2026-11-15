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
        Schema::create('unions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('location')->nullable();
            $table->text('map_url')->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('email', 128)->nullable();
            // Quick Statistics Badges
            $table->string('area_sq_km', 32)->nullable();
            $table->string('population', 64)->nullable();
            $table->string('voter_count', 64)->nullable();
            $table->string('village_count', 32)->nullable();
            $table->string('mouza_count', 32)->nullable();
            $table->string('literacy_rate', 32)->nullable();
            $table->boolean('status')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('union_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('union_id')->constrained('unions')->cascadeOnDelete();
            $table->string('image_path');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('union_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('union_id')->constrained('unions')->cascadeOnDelete();
            $table->string('name');
            $table->string('designation'); // ইউপি চেয়ারম্যান, ইউপি সদস্য (১নং ওয়ার্ড), ইত্যাদি
            $table->string('member_type', 32)->default('member'); // chairman, member, female_member
            $table->string('photo')->nullable();
            $table->string('qualification')->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('email', 128)->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('union_members');
        Schema::dropIfExists('union_images');
        Schema::dropIfExists('unions');
    }
};

