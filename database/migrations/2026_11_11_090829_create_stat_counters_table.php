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
        Schema::create('stat_counters', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g. সক্রিয় সদস্য, শিক্ষা প্রতিষ্ঠান, ইত্যাদি
            $table->string('count'); // e.g. ৫০০+, ২৫+, ৩০+, ১,৫০০+, ইত্যাদি (string allows + or Bengali numerals)
            $table->string('icon')->nullable(); // e.g. fa-solid fa-people-group or ri-book-open-line
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
        Schema::dropIfExists('stat_counters');
    }
};
