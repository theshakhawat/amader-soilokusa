<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use App\Models\SocialLink;
use App\Models\TopbarSetting;
use Illuminate\Database\Seeder;

class TopbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Topbar Settings (টপবার হেডার সেটিংস)
        TopbarSetting::firstOrCreate(
            ['id' => 1],
            [
                'is_active' => true,
                'show_contact' => true,
                'show_social' => true,
            ]
        );

        // 2. Contact Settings (টপবার ও ওয়েবসাইটের যোগাযোগের তথ্য ও গুগল ম্যাপ)
        ContactSetting::firstOrCreate(
            ['id' => 1],
            [
                'office_name' => 'আগামীর শৈলকুপা কেন্দ্রীয় কার্যালয়',
                'location' => 'শৈলকুপা',
                'phone' => '+880 1700-123456',
                'email' => 'info@agamirshailkupa.org',
                'alt_phone' => '+880 1800-123456',
                'address' => 'শৈলকুপা পৌরসভা মোড়, শৈলকুপা, ঝিনাইদহ, বাংলাদেশ',
                'map_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58548.86811211728!2d89.21376878206899!3d23.68962635959954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fed5b3d6d061f5%3A0xc07a829f03224b7!2sShailkupa!5e0!3m2!1sen!2sbd!4v1700000000000!5m2!1sen!2sbd" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            ]
        );

        // 3. Social Media Links (টপবার সোশ্যাল মিডিয়া আইকন ও লিংক)
        $socialLinks = [
            [
                'platform' => 'Facebook',
                'icon' => 'fa-brands fa-facebook-f',
                'url' => 'https://facebook.com',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'platform' => 'YouTube',
                'icon' => 'fa-brands fa-youtube',
                'url' => 'https://youtube.com',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'platform' => 'Instagram',
                'icon' => 'fa-brands fa-instagram',
                'url' => 'https://instagram.com',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'platform' => 'Twitter',
                'icon' => 'fa-brands fa-x-twitter',
                'url' => 'https://x.com',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($socialLinks as $link) {
            SocialLink::firstOrCreate(
                ['platform' => $link['platform']],
                $link
            );
        }
    }
}

