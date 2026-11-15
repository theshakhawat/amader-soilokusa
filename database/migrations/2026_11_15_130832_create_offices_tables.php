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
        // ১. অফিস সমূহ (Offices)
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('location')->nullable();
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // ২. অফিসের ব্যক্তিবর্গ / কর্মকর্তাবৃন্দ (Office Members)
        Schema::create('office_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained('offices')->cascadeOnDelete();
            $table->string('name');
            $table->string('designation');
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('qualification')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_members');
        Schema::dropIfExists('offices');
    }
};
