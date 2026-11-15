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
        Schema::create('person_messages', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('adviser'); // adviser, patron, president, executive, other
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('designation');
            $table->string('image')->nullable();
            $table->text('quote')->nullable();
            $table->longText('message')->nullable();
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
        Schema::dropIfExists('person_messages');
    }
};
