<?php

namespace Database\Seeders;

use App\Models\Pride;
use Illuminate\Database\Seeder;

class PrideSeeder extends Seeder
{
    public function run(): void
    {
        if (Pride::count() === 0) {
            Pride::create([
                'name' => 'বেগম খালেদা জিয়া',
                'designation' => 'সাবেক প্রধানমন্ত্রী, গণপ্রজাতন্ত্রী বাংলাদেশ সরকার',
                'photo' => 'assets/images/person-1.jpg',
                'order_index' => 1,
                'status' => true,
                'description' => '<p><strong>বেগম খালেদা জিয়া</strong> বাংলাদেশের প্রথম নারী প্রধানমন্ত্রী এবং বাংলাদেশ জাতীয়তাবাদী দল (বিএনপি)-এর চেয়ারপারসন। শৈলকুপা তথা বাংলাদেশের জাতীয় উন্নয়ন, গণতন্ত্র ও সার্বিক অগ্রগতিতে তাঁর অবদান চিরস্মরণীয়।</p>',
            ]);

            Pride::create([
                'name' => 'আসাদুজ্জামান খান',
                'designation' => 'মাননীয় আইনমন্ত্রী, বাংলাদেশ সরকার',
                'photo' => 'assets/images/person-2.jpg',
                'order_index' => 2,
                'status' => true,
                'description' => '<p>শৈলকুপার কৃতী সন্তান হিসেবে আইন ও বিচার ব্যবস্থার আধুনিকায়নে এবং শৈলকুপার বিভিন্ন উন্নয়নমূলক কর্মকাণ্ডে তাঁর দিকনির্দেশনা ও পৃষ্ঠপোষকতা স্মরণীয়।</p>',
            ]);

            Pride::create([
                'name' => 'জনাব জয়',
                'designation' => 'সংসদ সদস্য, ঝিনাইদহ-২',
                'photo' => 'assets/images/person-3.jpg',
                'order_index' => 3,
                'status' => true,
                'description' => '<p>ঝিনাইদহ-২ আসনের সংসদ সদস্য হিসেবে এলাকার অবকাঠামো, স্বাস্থ্য ও শিক্ষা প্রসারে তরুণ নেতৃত্বের অনন্য প্রতীক।</p>',
            ]);

            Pride::create([
                'name' => 'নিটুল ইসলাম',
                'designation' => 'সহ-প্রতিষ্ঠাতা, আগামীর শৈলকুপা',
                'photo' => 'assets/images/person-4.jpg',
                'order_index' => 4,
                'status' => true,
                'description' => '<p>আগামীর শৈলকুপা সামাজিক প্ল্যাটফর্মের সহ-প্রতিষ্ঠাতা হিসেবে তরুণ সমাজকে মানবিক উদ্যোগে ঐক্যবদ্ধ করতে অগ্রণী ভূমিকা পালন করছেন।</p>',
            ]);
        }
    }
}

