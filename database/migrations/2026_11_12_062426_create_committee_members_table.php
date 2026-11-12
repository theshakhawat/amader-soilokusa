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
        Schema::create('committee_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('committee_id')->nullable()->constrained('committees')->nullOnDelete();
            $table->string('name');
            $table->string('title');              // পদবী যেমন: সভাপতি, সহ-সভাপতি, সাধারণ সম্পাদক ইত্যাদি
            $table->string('photo')->nullable();
            $table->integer('order')->default(1); // 1 = সভাপতি, 2, 3 = দ্বিতীয় রো, বাকিগুলো ৩য় রো
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committee_members');
    }
};
