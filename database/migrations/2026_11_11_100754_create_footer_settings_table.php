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
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            // Col 1: Brand Info
            $table->string('brand_title')->default('আগামীর শৈলকুপা');
            $table->string('brand_subtitle')->default('শৈলকুপার উন্নয়নে আমরা এক পরিবার');
            $table->text('about_text')->nullable();
            $table->boolean('show_social_links')->default(true);

            // Col 2: Quick Links (JSON: array of {label, url})
            $table->string('quick_links_title')->default('দ্রুত লিংক');
            $table->json('quick_links')->nullable();

            // Col 3: Important Links (JSON: array of {label, url})
            $table->string('important_links_title')->default('গুরুত্বপূর্ণ লিংক');
            $table->json('important_links')->nullable();

            // Col 4: Contact Title
            $table->string('contact_title')->default('যোগাযোগ');

            // Bottom Copyright & Policies
            $table->string('copyright_text')->default('© ২০২৬ আগামীর শৈলকুপা। সর্বস্বত্ব সংরক্ষিত।');
            $table->string('privacy_policy_text')->default('গোপনীয়তা নীতি');
            $table->string('privacy_policy_link')->default('#');
            $table->string('terms_text')->default('ব্যবহারের শর্তাবলী');
            $table->string('terms_link')->default('#');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
