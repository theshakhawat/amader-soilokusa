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
        // ১. প্রতিষ্ঠানের ক্যাটাগরি (Institution Categories)
        Schema::create('institution_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // ২. প্রতিষ্ঠান সমূহ (Institutions)
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_category_id')->nullable()->constrained('institution_categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // ৩. প্রতিষ্ঠানের স্লাইডার ছবিসমূহ (Institution Images)
        Schema::create('institution_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institutions')->cascadeOnDelete();
            $table->string('image_path');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // ৪. প্রতিষ্ঠানের ব্যক্তিবর্গ (প্রধান শিক্ষক, সহকারী শিক্ষক, কর্মকর্তা ইত্যাদি)
        Schema::create('institution_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institutions')->cascadeOnDelete();
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
        Schema::dropIfExists('institution_members');
        Schema::dropIfExists('institution_images');
        Schema::dropIfExists('institutions');
        Schema::dropIfExists('institution_categories');
    }
};
