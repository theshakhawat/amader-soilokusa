<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\Committee;
use App\Models\CommitteeMember;
use App\Models\DonationSetting;
use App\Models\FooterSetting;
use App\Models\PresidentMessage;
use App\Models\SiteSetting;
use App\Models\StatCounter;
use Illuminate\Database\Seeder;

class SiteCustomizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Site Branding & Settings (লোগো, ফেভিকন ও টাইটেল)
        SiteSetting::firstOrCreate(
            ['id' => 1],
            [
                'site_title' => 'আগামীর শৈলকুপা',
                'site_tagline' => 'শৈলকুপার উন্নয়নে আমরা এক পরিবার',
                'header_logo' => 'assets/images/logo-icon.png',
                'footer_logo' => 'assets/images/logo-icon.png',
                'favicon' => 'assets/images/logo-icon.png',
            ]
        );

        // 2. Stat Counters (পরিসংখ্যান কাউন্টার বার)
        $counters = [
            [
                'title' => 'সক্রিয় সদস্য',
                'count' => '৫০০+',
                'icon' => 'ri-team-line',
                'order' => 1,
                'status' => true,
            ],
            [
                'title' => 'শিক্ষা প্রতিষ্ঠান',
                'count' => '২৫+',
                'icon' => 'ri-book-open-line',
                'order' => 2,
                'status' => true,
            ],
            [
                'title' => 'উন্নয়ন প্রকল্প',
                'count' => '৩০+',
                'icon' => 'ri-stack-line',
                'order' => 3,
                'status' => true,
            ],
            [
                'title' => 'দর্শনীয় স্থান',
                'count' => '২০+',
                'icon' => 'ri-map-pin-line',
                'order' => 4,
                'status' => true,
            ],
            [
                'title' => 'আয়োজিত অনুষ্ঠান',
                'count' => '৫০+',
                'icon' => 'ri-calendar-event-line',
                'order' => 5,
                'status' => true,
            ],
        ];

        foreach ($counters as $c) {
            StatCounter::firstOrCreate(['title' => $c['title']], $c);
        }

        // 3. About Section (আমাদের সম্পর্কে)
        AboutSection::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'আমাদের সম্পর্কে',
                'subtitle' => 'শৈলকুপার সার্বিক উন্নয়নে আমরা ঐক্যবদ্ধ',
                'short_description' => 'আগামীর শৈলকুপা একটি অরাজনৈতিক সামাজিক উদ্যোগ, যা শৈলকুপার সার্বিক উন্নয়ন, শিক্ষা, স্বাস্থ্য, সামাজিক কল্যাণ ও ঐতিহ্য সংরক্ষণে নিরলসভাবে কাজ করে যাচ্ছে।',
                'description' => '<p>আগামীর শৈলকুপা একটি অরাজনৈতিক সামাজিক কল্যাণমূলক উদ্যোগ। আমরা শৈলকুপা উপজেলার সার্বিক উন্নয়ন, মানসম্মত শিক্ষা বিস্তার, স্বাস্থ্যসেবা উন্নয়ন, পরিবেশ রক্ষা এবং ঐতিহ্যবাহী সংস্কৃতি সংরক্ষণে কাজ করে যাচ্ছি। আমাদের লক্ষ্য প্রতিটি নাগরিককে সাথে নিয়ে একটি আধুনিক, মানবিক ও আত্মনির্ভরশীল শৈলকুপা গড়ে তোলা।</p>',
                'image' => 'assets/images/about-shaheed-minar.jpg',
                'button_text' => 'বিস্তারিত পড়ুন',
            ]
        );

        // 4. President Message (সভাপতির বাণী)
        PresidentMessage::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'সভাপতির বাণী',
                'name' => 'মোঃ আব্দুল করিম',
                'designation' => 'সভাপতি, আগামীর শৈলকুপা',
                'quote' => 'শৈলকুপাকে একটি আধুনিক, শিক্ষিত, সমৃদ্ধ ও মানবিক জনপদে রূপ দিতে আমরা সবাই একসাথে কাজ করছি।',
                'message' => '<p>প্রিয় শৈলকুপাবাসী, আসসালামু আলাইকুম। আগামীর শৈলকুপা কোনো গতানুগতিক সংগঠন নয়, এটি আমাদের জন্মভূমির প্রতি দায়িত্ববোধ ও ভালোবাসার এক সম্মিলিত প্রকাশ। শৈলকুপার ইতিহাস, ঐতিহ্য ও প্রাকৃতিক সৌন্দর্য রক্ষা করে এখানকার শিক্ষা, স্বাস্থ্য ও কর্মসংস্থানের সুযোগ সৃষ্টি করাই আমাদের মূল লক্ষ্য। আসুন, দলমত নির্বিশেষে আমরা সবাই মিলে আমাদের শৈলকুপাকে এক অনন্য উচ্চতায় নিয়ে যাই।</p>',
                'image' => 'assets/images/president.jpg',
            ]
        );

        // 5. Donation Banner Settings (অনুদান ব্যানার)
        DonationSetting::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'শৈলকুপার উন্নয়নে<br>আপনিও অংশ নিন',
                'description' => 'শিক্ষা, স্বাস্থ্য, সামাজিক উন্নয়ন ও মানবকল্যাণমূলক কার্যক্রমে আপনার অনুদান আমাদের প্রেরণা।',
                'button_text' => 'অনুদান দিন এখনই',
                'button_link' => '#',
                'image' => 'assets/images/donate-sapling.jpg',
                'bg_color_start' => '#8f0d20',
                'bg_color_end' => '#c8102e',
                'text_color' => '#ffffff',
                'button_bg_color' => '#ffffff',
                'button_text_color' => '#0b4622',
                'status' => true,
            ]
        );

        // 6. Committee & Committee Members (কার্যনির্বাহী কমিটি)
        $committee = Committee::firstOrCreate(
            ['name' => 'কার্যনির্বাহী কমিটি'],
            [
                'session_duration' => '২০২৬-২০২৮',
                'subtitle' => 'আগামীর শৈলকুপা',
                'image' => 'assets/images/committee.jpg',
                'description' => 'আগামীর শৈলকুপা কেন্দ্রীয় কার্যনির্বাহী সংসদ',
                'is_active' => true,
                'order' => 1,
            ]
        );

        $members = [
            ['name' => 'মোঃ আব্দুল করিম', 'title' => 'সভাপতি', 'order' => 1, 'status' => true],
            ['name' => 'নিটুল ইসলাম', 'title' => 'সহ-সভাপতি', 'order' => 2, 'status' => true],
            ['name' => 'মোঃ রফিকুল ইসলাম', 'title' => 'সাধারণ সম্পাদক', 'order' => 3, 'status' => true],
            ['name' => 'আব্দুর রহমান', 'title' => 'যুগ্ম-সাধারণ সম্পাদক', 'order' => 4, 'status' => true],
            ['name' => 'মোঃ কামরুল হাসান', 'title' => 'সাংগঠনিক সম্পাদক', 'order' => 5, 'status' => true],
            ['name' => 'মাহবুবুর রহমান', 'title' => 'কোষাধ্যক্ষ', 'order' => 6, 'status' => true],
            ['name' => 'তাহসিন আহমেদ', 'title' => 'প্রচার সম্পাদক', 'order' => 7, 'status' => true],
            ['name' => 'আরিফুল হক', 'title' => 'দপ্তর সম্পাদক', 'order' => 8, 'status' => true],
        ];

        foreach ($members as $m) {
            $m['committee_id'] = $committee->id;
            CommitteeMember::firstOrCreate(
                ['name' => $m['name'], 'committee_id' => $committee->id],
                $m
            );
        }

        // 7. Footer Settings (ফুটার কন্টেন্ট, কুইক লিংক ও যোগাযোগ)
        FooterSetting::firstOrCreate(
            ['id' => 1],
            [
                'brand_title' => 'আগামীর শৈলকুপা',
                'brand_subtitle' => 'শৈলকুপার উন্নয়নে আমরা এক পরিবার',
                'about_text' => 'আগামীর শৈলকুপা একটি অরাজনৈতিক সামাজিক কল্যাণমূলক উদ্যোগ। আমরা শৈলকুপার শিক্ষা, স্বাস্থ্য, পরিবেশ ও সামগ্রিক জনকল্যাণে ঐক্যবদ্ধভাবে নিবেদিত।',
                'show_social_links' => true,
                'quick_links_title' => 'দ্রুত লিংক',
                'quick_links' => [
                    ['label' => 'হোম', 'url' => '/#hero-section'],
                    ['label' => 'আমাদের সম্পর্কে', 'url' => '/page/aboutus'],
                    ['label' => 'নোটিশ', 'url' => '/#notice-section'],
                    ['label' => 'কার্যক্রম', 'url' => '/#events-section'],
                    ['label' => 'গ্যালারি', 'url' => '/#gallery-section'],
                ],
                'important_links_title' => 'গুরুত্বপূর্ণ লিংক',
                'important_links' => [
                    ['label' => 'কমিটি', 'url' => '/committee'],
                    ['label' => 'উন্নয়ন প্রকল্পসমূহ', 'url' => '/projects'],
                    ['label' => 'দর্শনীয় স্থান', 'url' => '/places'],
                    ['label' => 'ব্লগ ও আপডেট', 'url' => '/blogs'],
                    ['label' => 'যোগাযোগ', 'url' => '/contact'],
                ],
                'contact_title' => 'যোগাযোগ',
                'copyright_text' => '© ' . date('Y') . ' আগামীর শৈলকুপা। সর্বস্বত্ব সংরক্ষিত।',
                'privacy_policy_text' => 'গোপনীয়তা নীতি',
                'privacy_policy_link' => '#',
                'terms_text' => 'ব্যবহারের শর্তাবলী',
                'terms_link' => '#',
            ]
        );
    }
}
