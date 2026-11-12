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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date')->nullable();
            $table->enum('status', ['active', 'inactive', 'pinned'])->default('active');
            $table->longText('description')->nullable();
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        Schema::create('notice_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notice_id')->constrained('notices')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable(); // pdf, doc, image, etc.
            $table->bigInteger('file_size')->nullable(); // in bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notice_files');
        Schema::dropIfExists('notices');
    }
};
