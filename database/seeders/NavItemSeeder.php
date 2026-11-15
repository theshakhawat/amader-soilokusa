<?php

namespace Database\Seeders;

use App\Models\NavItem;
use Illuminate\Database\Seeder;

class NavItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NavItem::query()->delete();

        // 1. হোম
        NavItem::create([
            'title'     => 'হোম',
            'url'       => '/',
            'parent_id' => null,
            'order'     => 1,
            'status'    => true,
        ]);

        // 2. আমাদের সম্পর্কে
        $about = NavItem::create([
            'title'     => 'আমাদের সম্পর্কে',
            'url'       => '#',
            'parent_id' => null,
            'order'     => 2,
            'status'    => true,
        ]);

        $aboutChildren = [
            ['title' => 'উপদেষ্টা বাণী', 'url' => '/message/adviser'],
            ['title' => 'পৃষ্ঠপোষকের বাণী', 'url' => '/message/patron'],
            ['title' => 'সভাপতির বাণী', 'url' => '/message/president'],
            ['title' => 'কার্যনির্বাহীর বাণী', 'url' => '/message/executive'],
            ['title' => 'লক্ষ্য এবং উদ্দেশ্য', 'url' => '/page/aboutus'],
        ];

        foreach ($aboutChildren as $idx => $child) {
            NavItem::create([
                'parent_id' => $about->id,
                'title'     => $child['title'],
                'url'       => $child['url'],
                'order'     => $idx + 1,
                'status'    => true,
            ]);
        }

        // 3. উপজেলা পরিচিতি
        $upazila = NavItem::create([
            'title'     => 'উপজেলা পরিচিতি',
            'url'       => '#',
            'parent_id' => null,
            'order'     => 3,
            'status'    => true,
        ]);

        // ইউনিয়ন পরিচিতি
        $unionParent = NavItem::create([
            'parent_id' => $upazila->id,
            'title'     => 'ইউনিয়ন পরিচিতি',
            'url'       => '#',
            'order'     => 1,
            'status'    => true,
        ]);

        $unions = [
            '১নং ত্রিবেনী',
            '২নং মির্জাপুর',
            '৩নং দিগনগর',
            '৪নং কাঁচেরকোল',
            '৫নং সারুটিয়া',
            '৬নং হাকিমপুর',
            '৭নং ধলহরাচন্দ্র',
            '৮নং মনোহরপুর',
            '৯নং বগুড়া',
            '১০নং আবাইপুর',
            '১১নং নিত্যানন্দপুর',
            '১২নং উমেদপুর',
            '১৩নং দুধসর',
            '১৪নং ফুলহরি',
        ];

        foreach ($unions as $uIdx => $uName) {
            $uItem = NavItem::create([
                'parent_id' => $unionParent->id,
                'title'     => $uName,
                'url'       => '#',
                'order'     => $uIdx + 1,
                'status'    => true,
            ]);

            NavItem::create([
                'parent_id' => $uItem->id,
                'title'     => 'চেয়ারম্যান',
                'url'       => '/page/union-' . \Illuminate\Support\Str::slug($uName) . '-chairman',
                'order'     => 1,
                'status'    => true,
            ]);
            NavItem::create([
                'parent_id' => $uItem->id,
                'title'     => 'মেম্বার',
                'url'       => '/page/union-' . \Illuminate\Support\Str::slug($uName) . '-member',
                'order'     => 2,
                'status'    => true,
            ]);
            NavItem::create([
                'parent_id' => $uItem->id,
                'title'     => 'মহিলা মেম্বার',
                'url'       => '/page/union-' . \Illuminate\Support\Str::slug($uName) . '-female-member',
                'order'     => 3,
                'status'    => true,
            ]);
        }

        // 4. প্রতিষ্ঠান সমূহ
        $institutes = NavItem::create([
            'title'     => 'প্রতিষ্ঠান সমূহ',
            'url'       => '#',
            'parent_id' => null,
            'order'     => 4,
            'status'    => true,
        ]);

        $instChildren = [
            ['title' => 'ইউনিভার্সিটি', 'url' => '/institutions/university', 'icon' => 'ri-building-4-line'],
            ['title' => 'কলেজ', 'url' => '/institutions/college', 'icon' => 'ri-community-line'],
            ['title' => 'মাধ্যমিক বিদ্যালয়', 'url' => '/institutions/secondary-school', 'icon' => 'ri-graduation-cap-line'],
            ['title' => 'প্রাথমিক বিদ্যালয়', 'url' => '/institutions/primary-school', 'icon' => 'ri-book-open-line'],
            ['title' => 'কিন্ডারগার্টেন', 'url' => '/institutions/kindergarten', 'icon' => 'ri-bear-smile-line'],
            ['title' => 'মাদ্রাসা', 'url' => '/institutions/madrasa', 'icon' => 'ri-compass-3-line'],
        ];

        foreach ($instChildren as $idx => $inst) {
            NavItem::create([
                'parent_id' => $institutes->id,
                'title'     => $inst['title'],
                'url'       => $inst['url'],
                'icon'      => $inst['icon'],
                'order'     => $idx + 1,
                'status'    => true,
            ]);
        }

        // 5. অফিস সমূহ
        $offices = NavItem::create([
            'title'     => 'অফিস সমূহ',
            'url'       => '#',
            'parent_id' => null,
            'order'     => 5,
            'status'    => true,
        ]);

        $officeChildren = [
            ['title' => 'UNO অফিস (নির্বাহী অফিস)', 'url' => '/offices/uno-office', 'icon' => 'ri-government-line'],
            ['title' => 'উপজেলা কৃষি অফিস', 'url' => '/offices/agriculture-office', 'icon' => 'ri-plant-line'],
            ['title' => 'শৈলকূপা থানা / পুলিশ অফিস', 'url' => '/offices/police-office', 'icon' => 'ri-shield-line'],
            ['title' => 'উপজেলা স্বাস্থ্য কমপ্লেক্স', 'url' => '/offices/health-complex', 'icon' => 'ri-hospital-line'],
            ['title' => 'উপজেলা ভূমি অফিস (এসি ল্যান্ড)', 'url' => '/offices/land-office', 'icon' => 'ri-file-text-line'],
            ['title' => 'অন্যান্য সরকারি অফিসসমূহ', 'url' => '/offices', 'icon' => 'ri-building-line'],
        ];

        foreach ($officeChildren as $idx => $off) {
            NavItem::create([
                'parent_id' => $offices->id,
                'title'     => $off['title'],
                'url'       => $off['url'],
                'icon'      => $off['icon'],
                'order'     => $idx + 1,
                'status'    => true,
            ]);
        }

        // 6. কমিটি
        $committee = NavItem::create([
            'title'     => 'কমিটি',
            'url'       => '#',
            'parent_id' => null,
            'order'     => 6,
            'status'    => true,
        ]);

        NavItem::create([
            'parent_id' => $committee->id,
            'title'     => 'কার্যনির্বাহী কমিটি',
            'url'       => '/committee',
            'icon'      => 'ri-team-line',
            'order'     => 1,
            'status'    => true,
        ]);

        $subcomm = NavItem::create([
            'parent_id' => $committee->id,
            'title'     => 'উপকমিটি সমূহ',
            'url'       => '#',
            'icon'      => 'ri-organization-chart',
            'order'     => 2,
            'status'    => true,
        ]);

        $subcommChildren = [
            ['title' => 'কৃষি কমিটি', 'url' => '/page/subcommittee-agriculture', 'icon' => 'ri-plant-line'],
            ['title' => 'স্বাস্থ্য চিকিৎসা', 'url' => '/page/subcommittee-health', 'icon' => 'ri-heart-pulse-line'],
            ['title' => 'আইনশৃঙ্খলা ও মাদক', 'url' => '/page/subcommittee-law-order', 'icon' => 'ri-shield-user-line'],
            ['title' => 'শিক্ষা কমিটি', 'url' => '/page/subcommittee-education', 'icon' => 'ri-book-3-line'],
            ['title' => 'উন্নয়ন কমিটি', 'url' => '/page/subcommittee-development', 'icon' => 'ri-building-line'],
            ['title' => 'খেলাধুলা কমিটি', 'url' => '/page/subcommittee-sports', 'icon' => 'ri-football-line'],
            ['title' => 'সাংস্কৃতিক কমিটি', 'url' => '/page/subcommittee-culture', 'icon' => 'ri-music-2-line'],
        ];

        foreach ($subcommChildren as $idx => $sc) {
            NavItem::create([
                'parent_id' => $subcomm->id,
                'title'     => $sc['title'],
                'url'       => $sc['url'],
                'icon'      => $sc['icon'],
                'order'     => $idx + 1,
                'status'    => true,
            ]);
        }

        // 7. যোগাযোগ
        NavItem::create([
            'title'     => 'যোগাযোগ',
            'url'       => '/contact',
            'parent_id' => null,
            'order'     => 7,
            'status'    => true,
        ]);
    }
}

