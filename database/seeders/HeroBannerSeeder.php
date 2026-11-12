<?php

namespace Database\Seeders;

use App\Models\HeroBanner;
use Illuminate\Database\Seeder;

class HeroBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'আগামীর শৈলকুপা',
                'subtitle' => 'শৈলকুপার উন্নয়ন, ঐতিহ্য ও মানুষের অগ্রযাত্রার একটি স্বেচ্ছাসেবী সামাজিক উদ্যোগ',
                'badge' => 'স্বেচ্ছাসেবী প্ল্যাটফর্ম',
                'primary_button_text' => 'আমাদের সম্পর্কে জানুন',
                'primary_button_link' => '#about-section',
                'secondary_button_text' => 'ভিডিও দেখুন',
                'secondary_button_link' => '#video',
                'image' => 'assets/images/hero-shailkupa.jpg',
                'order' => 1,
                'status' => true,
            ],
            [
                'title' => 'ঐতিহ্য ও আধুনিকতার মেলবন্ধনে শৈলকুপা',
                'subtitle' => 'শিক্ষা, সংস্কৃতি ও সামাজিক উন্নয়নে আমরা ঐক্যবদ্ধভাবে শৈলকুপার সার্বিক অগ্রগতিতে কাজ করছি',
                'badge' => 'উন্নয়ন উদ্যোগ',
                'primary_button_text' => 'কার্যক্রম দেখুন',
                'primary_button_link' => '#events-section',
                'secondary_button_text' => 'অনুদান দিন',
                'secondary_button_link' => '#donation-section',
                'image' => 'assets/images/about-shaheed-minar.jpg',
                'order' => 2,
                'status' => true,
            ],
            [
                'title' => 'স্মার্ট ও সমৃদ্ধ আগামী বিনির্মাণে',
                'subtitle' => 'শৈলকুপার প্রতিটি নাগরিকের কল্যাণে এবং উন্নত ভবিষ্যৎ নিশ্চিতকরণে আমাদের সমন্বিত প্রয়াস',
                'badge' => 'অগ্রযাত্রা',
                'primary_button_text' => 'উন্নয়ন প্রকল্পসমূহ',
                'primary_button_link' => '#projects-section',
                'secondary_button_text' => 'যোগাযোগ করুন',
                'secondary_button_link' => '/contact',
                'image' => 'assets/images/project-road.jpg',
                'order' => 3,
                'status' => true,
            ],
        ];

        foreach ($banners as $banner) {
            HeroBanner::firstOrCreate(
                ['title' => $banner['title']],
                $banner
            );
        }
    }
}

