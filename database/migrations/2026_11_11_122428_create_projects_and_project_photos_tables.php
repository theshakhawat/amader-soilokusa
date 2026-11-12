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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('project_status', ['running', 'completed', 'upcoming'])->default('running');
            $table->longText('description')->nullable();
            $table->boolean('status')->default(true); // active / inactive
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        Schema::create('project_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_photos');
        Schema::dropIfExists('projects');
    }
};
