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
            'url'       => '/unions',
            'parent_id' => null,
            'order'     => 3,
            'status'    => true,
        ]);

        // সমস্ত ইউনিয়ন সমূহ (মূল পরিচিতি লিংক)
        NavItem::create([
            'parent_id' => $upazila->id,
            'title'     => 'সমস্ত ইউনিয়ন সমূহ',
            'url'       => '/unions',
            'icon'      => 'ri-community-line',
            'order'     => 1,
            'status'    => true,
        ]);

        $unions = [
            ['title' => '১নং ত্রিবেনী', 'slug' => 'triveni'],
            ['title' => '২নং মির্জাপুর', 'slug' => 'mirzapur'],
            ['title' => '৩নং দিগনগর', 'slug' => 'dignagar'],
            ['title' => '৪নং কাঁচেরকোল', 'slug' => 'kancherkol'],
            ['title' => '৫নং সারুটিয়া', 'slug' => 'sarutia'],
            ['title' => '৬নং হাকিমপুর', 'slug' => 'hakimpur'],
            ['title' => '৭নং ধলহরাচন্দ্র', 'slug' => 'dhalharachandra'],
            ['title' => '৮নং মনোহরপুর', 'slug' => 'manoharpur'],
            ['title' => '৯নং বগুড়া', 'slug' => 'bogura'],
            ['title' => '১০নং আবাইপুর', 'slug' => 'abaipur'],
            ['title' => '১১নং নিত্যানন্দপুর', 'slug' => 'nityanandapur'],
            ['title' => '১২নং উমেদপুর', 'slug' => 'umedpur'],
            ['title' => '১৩নং দুধসর', 'slug' => 'dudhsar'],
            ['title' => '১৪নং ফুলহরি', 'slug' => 'phulhari'],
        ];

        foreach ($unions as $uIdx => $u) {
            NavItem::create([
                'parent_id' => $upazila->id,
                'title'     => $u['title'],
                'url'       => '/unions/' . $u['slug'],
                'icon'      => 'ri-building-line',
                'order'     => $uIdx + 2,
                'status'    => true,
            ]);
        }

        // 4. প্রতিষ্ঠান সমূহ
        $institutes = NavItem::create([
            'title'     => 'প্রতিষ্ঠান সমূহ',
            'url'       => '/institutions',
            'parent_id' => null,
            'order'     => 4,
            'status'    => true,
        ]);

        NavItem::create([
            'parent_id' => $institutes->id,
            'title'     => 'সমস্ত প্রতিষ্ঠান সমূহ',
            'url'       => '/institutions',
            'icon'      => 'ri-building-line',
            'order'     => 1,
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
                'order'     => $idx + 2,
                'status'    => true,
            ]);
        }

        // 5. অফিস সমূহ
        $offices = NavItem::create([
            'title'     => 'অফিস সমূহ',
            'url'       => '/offices',
            'parent_id' => null,
            'order'     => 5,
            'status'    => true,
        ]);

        NavItem::create([
            'parent_id' => $offices->id,
            'title'     => 'সমস্ত অফিস সমূহ',
            'url'       => '/offices',
            'icon'      => 'ri-government-line',
            'order'     => 1,
            'status'    => true,
        ]);

        $officeChildren = [
            ['title' => 'UNO অফিস (নির্বাহী অফিস)', 'url' => '/offices/uno-office', 'icon' => 'ri-government-line'],
            ['title' => 'উপজেলা কৃষি অফিস', 'url' => '/offices/agriculture-office', 'icon' => 'ri-plant-line'],
            ['title' => 'শৈলকূপা থানা / পুলিশ অফিস', 'url' => '/offices/police-office', 'icon' => 'ri-shield-line'],
            ['title' => 'উপজেলা স্বাস্থ্য কমপ্লেক্স', 'url' => '/offices/health-complex', 'icon' => 'ri-hospital-line'],
            ['title' => 'উপজেলা ভূমি অফিস (এসি ল্যান্ড)', 'url' => '/offices/land-office', 'icon' => 'ri-file-text-line'],
        ];

        foreach ($officeChildren as $idx => $off) {
            NavItem::create([
                'parent_id' => $offices->id,
                'title'     => $off['title'],
                'url'       => $off['url'],
                'icon'      => $off['icon'],
                'order'     => $idx + 2,
                'status'    => true,
            ]);
        }

        // 6. কমিটি
        $committee = NavItem::create([
            'title'     => 'কমিটি',
            'url'       => '/committee',
            'parent_id' => null,
            'order'     => 6,
            'status'    => true,
        ]);

        NavItem::create([
            'parent_id' => $committee->id,
            'title'     => 'সকল কমিটি সমূহ',
            'url'       => '/committee',
            'icon'      => 'ri-function-line',
            'order'     => 1,
            'status'    => true,
        ]);

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

