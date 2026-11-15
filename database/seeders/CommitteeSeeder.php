<?php

namespace Database\Seeders;

use App\Models\Committee;
use App\Models\CommitteeMember;
use Illuminate\Database\Seeder;

class CommitteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. কেন্দ্রীয় কার্যনির্বাহী কমিটি (Second row = 2: সহ-সভাপতি ও সাধারণ সম্পাদক)
        $executive = Committee::updateOrCreate(
            ['slug' => 'executive'],
            [
                'name'             => 'কার্যনির্বাহী কমিটি',
                'session_duration' => '২০২৬-২০২৮',
                'subtitle'         => 'আগামীর শৈলকুপা কেন্দ্রীয় কার্যনির্বাহী পরিষদ',
                'image'            => 'assets/images/committee.jpg',
                'description'      => 'আগামীর শৈলকুপা কেন্দ্রীয় কার্যনির্বাহী পরিষদ তৃণমূল পর্যায়ে মানুষের পাশে দাঁড়াতে ও সার্বিক উন্নয়নে নিবেদিত।',
                'second_row_count' => 2,
                'is_active'        => true,
                'order'            => 1,
            ]
        );

        $execMembers = [
            ['name' => 'মোঃ আব্দুল করিম', 'title' => 'সভাপতি', 'phone' => '01711234501', 'order' => 1, 'status' => true],
            ['name' => 'নিটুল ইসলাম', 'title' => 'সহ-সভাপতি', 'phone' => '01711234502', 'order' => 2, 'status' => true],
            ['name' => 'মোঃ রফিকুল ইসলাম', 'title' => 'সাধারণ সম্পাদক', 'phone' => '01711234503', 'order' => 3, 'status' => true],
            ['name' => 'আব্দুর রহমান', 'title' => 'যুগ্ম-সাধারণ সম্পাদক', 'phone' => '01711234504', 'order' => 4, 'status' => true],
            ['name' => 'মোঃ কামরুল হাসান', 'title' => 'সাংগঠনিক সম্পাদক', 'phone' => '01711234505', 'order' => 5, 'status' => true],
            ['name' => 'মাহবুবুর রহমান', 'title' => 'কোষাধ্যক্ষ', 'phone' => '01711234506', 'order' => 6, 'status' => true],
            ['name' => 'তাহসিন আহমেদ', 'title' => 'প্রচার সম্পাদক', 'phone' => '01711234507', 'order' => 7, 'status' => true],
            ['name' => 'আরিফুল হক', 'title' => 'দপ্তর সম্পাদক', 'phone' => '01711234508', 'order' => 8, 'status' => true],
        ];

        foreach ($execMembers as $m) {
            CommitteeMember::updateOrCreate(
                ['committee_id' => $executive->id, 'name' => $m['name']],
                $m
            );
        }

        // 2. কৃষি ও পল্লী উন্নয়ন কমিটি (Second row = 3: ৩ জন শীর্ষ দায়িত্বশীল)
        $agriculture = Committee::updateOrCreate(
            ['slug' => 'agriculture-committee'],
            [
                'name'             => 'কৃষি ও পল্লী উন্নয়ন কমিটি',
                'session_duration' => '২০২৬-২০২৮',
                'subtitle'         => 'শৈলকুপা উপজেলা কৃষক কল্যাণ ও পল্লী উন্নয়ন উপকমিটি',
                'image'            => 'assets/images/committee.jpg',
                'description'      => 'শৈলকুপার আধুনিক কৃষি প্রযুক্তি বিস্তার, উন্নত বীজ ও সার ব্যবস্থাপনা এবং কৃষক সহায়তা প্রদান।',
                'second_row_count' => 3,
                'is_active'        => true,
                'order'            => 2,
            ]
        );

        $agriMembers = [
            ['name' => 'ড. এ.কে.এম. শহিদুল্লাহ', 'title' => 'আহ্বায়ক (সভাপতি)', 'phone' => '01712003301', 'order' => 1, 'status' => true],
            ['name' => 'কৃষিবিদ মশিউর রহমান', 'title' => 'সদস্য সচিব', 'phone' => '01712003302', 'order' => 2, 'status' => true],
            ['name' => 'মোঃ এনামুল হক', 'title' => 'যুগ্ম আহ্বায়ক', 'phone' => '01712003303', 'order' => 3, 'status' => true],
            ['name' => 'মোঃ তারিকুল ইসলাম', 'title' => 'যুগ্ম আহ্বায়ক', 'phone' => '01712003304', 'order' => 4, 'status' => true],
            ['name' => 'মোঃ আসাদুজ্জামান', 'title' => 'সদস্য (মাঠ সমন্বয়ক)', 'phone' => '01712003305', 'order' => 5, 'status' => true],
            ['name' => 'কৃষিবিদ সুব্রত কুমার', 'title' => 'সদস্য (প্রযুক্তি পরামর্শক)', 'phone' => '01712003306', 'order' => 6, 'status' => true],
            ['name' => 'মোঃ রেজাউল ইসলাম', 'title' => 'সদস্য (বীজ ও সার তদারকি)', 'phone' => '01712003307', 'order' => 7, 'status' => true],
        ];

        foreach ($agriMembers as $m) {
            CommitteeMember::updateOrCreate(
                ['committee_id' => $agriculture->id, 'name' => $m['name']],
                $m
            );
        }

        // 3. শিক্ষা, সাহিত্য ও সংস্কৃতি কমিটি (Second row = 2: ২ জন দায়িত্বশীল)
        $education = Committee::updateOrCreate(
            ['slug' => 'education-culture-committee'],
            [
                'name'             => 'শিক্ষা ও সংস্কৃতি কমিটি',
                'session_duration' => '২০২৬-২০২৮',
                'subtitle'         => 'মেধা বিকাশ, শিক্ষা বৃত্তি ও সাংস্কৃতিক জাগরণ পরিষদ',
                'image'            => 'assets/images/committee.jpg',
                'description'      => 'শৈলকুপায় মেধা অন্বেষণ প্রতিযোগিতা, দরিদ্র শিক্ষার্থীদের বৃত্তি প্রদান ও ঐতিহ্যবাহী সাংস্কৃতিক উৎসব আয়োজন।',
                'second_row_count' => 2,
                'is_active'        => true,
                'order'            => 3,
            ]
        );

        $eduMembers = [
            ['name' => 'প্রফেসর এম. এ. লতিফ', 'title' => 'সভাপতি', 'phone' => '01713004401', 'order' => 1, 'status' => true],
            ['name' => 'মোঃ জয়নাল আবেদিন', 'title' => 'সাধারণ সম্পাদক', 'phone' => '01713004402', 'order' => 2, 'status' => true],
            ['name' => 'নাজমুল হুদা', 'title' => 'যুগ্ম সাধারণ সম্পাদক', 'phone' => '01713004403', 'order' => 3, 'status' => true],
            ['name' => 'ফারহানা পারভীন', 'title' => 'সাংস্কৃতিক সম্পাদক', 'phone' => '01713004404', 'order' => 4, 'status' => true],
            ['name' => 'মোঃ কবির হোসেন', 'title' => 'শিক্ষা ও বৃত্তি বিষয়ক সম্পাদক', 'phone' => '01713004405', 'order' => 5, 'status' => true],
            ['name' => 'তানজিলা রহমান', 'title' => 'কার্যকরী সদস্য', 'phone' => '01713004406', 'order' => 6, 'status' => true],
        ];

        foreach ($eduMembers as $m) {
            CommitteeMember::updateOrCreate(
                ['committee_id' => $education->id, 'name' => $m['name']],
                $m
            );
        }

        // 4. স্বাস্থ্য ও মানবিক সেবা কমিটি (Second row = 2)
        $health = Committee::updateOrCreate(
            ['slug' => 'health-service-committee'],
            [
                'name'             => 'স্বাস্থ্য ও মানবিক সেবা কমিটি',
                'session_duration' => '২০২৬-২০২৮',
                'subtitle'         => 'বিনামূল্যে চিকিৎসাসেবা ও রক্তদান কর্মসূচি উপকমিটি',
                'image'            => 'assets/images/committee.jpg',
                'description'      => 'জরুরি রক্তদান নেটওয়ার্ক পরিচালনা, ভ্রাম্যমাণ ফ্রি মেডিকেল ক্যাম্প এবং অসহায় রোগীদের ওষুধ সহায়তা।',
                'second_row_count' => 2,
                'is_active'        => true,
                'order'            => 4,
            ]
        );

        $healthMembers = [
            ['name' => 'ডাঃ মোঃ মাহমুদুর রহমান', 'title' => 'আহ্বায়ক (সভাপতি)', 'phone' => '01714005501', 'order' => 1, 'status' => true],
            ['name' => 'ডাঃ আতিকুর রহমান', 'title' => 'সদস্য সচিব', 'phone' => '01714005502', 'order' => 2, 'status' => true],
            ['name' => 'মোঃ সাইদুর রহমান', 'title' => 'যুগ্ম আহ্বায়ক (রক্তদান সমন্বয়)', 'phone' => '01714005503', 'order' => 3, 'status' => true],
            ['name' => 'মোঃ শফিকুল ইসলাম', 'title' => 'সদস্য (ফার্মাসি ও লজিস্টিক)', 'phone' => '01714005504', 'order' => 4, 'status' => true],
            ['name' => 'মোছাঃ সুরাইয়া পারভীন', 'title' => 'সদস্য (মা ও শিশু স্বাস্থ্য)', 'phone' => '01714005505', 'order' => 5, 'status' => true],
        ];

        foreach ($healthMembers as $m) {
            CommitteeMember::updateOrCreate(
                ['committee_id' => $health->id, 'name' => $m['name']],
                $m
            );
        }
    }
}

