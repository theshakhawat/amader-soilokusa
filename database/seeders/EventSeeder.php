<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        if (Event::count() === 0) {
            Event::create([
                'title' => 'শিক্ষা বৃত্তি বিতরণ অনুষ্ঠান',
                'thumbnail' => 'assets/images/event-1.jpg',
                'date' => '2026-11-15',
                'time' => 'সকাল ১০:০০',
                'location' => 'শৈলকুপা পাবলিক হল',
                'status' => 'active',
                'order_index' => 1,
                'description' => '<p><strong>শিক্ষা বৃত্তি বিতরণ অনুষ্ঠান</strong></p><p>শৈলকুপা উপজেলার বিভিন্ন স্কুল ও কলেজের মেধাবী ও অসচ্ছল শিক্ষার্থীদের মাঝে বার্ষিক শিক্ষাবৃত্তি ও শিক্ষা উপকরণ বিতরণ অনুষ্ঠান। অনুষ্ঠানে প্রধান অতিথি হিসেবে উপস্থিত থাকবেন বিশিষ্ট শিক্ষাবিদ ও স্থানীয় গণ্যমান্য ব্যক্তিবর্গ।</p>',
            ]);

            Event::create([
                'title' => 'বৃক্ষরোপণ কর্মসূচি',
                'thumbnail' => 'assets/images/event-2.jpg',
                'date' => '2026-11-20',
                'time' => 'সকাল ৯:০০',
                'location' => 'শৈলকুপা উপজেলা এলাকা',
                'status' => 'active',
                'order_index' => 2,
                'description' => '<p><strong>বৃক্ষরোপণ কর্মসূচি</strong></p><p>সবুজ ও পরিবেশবান্ধব শৈলকুপা গড়ার লক্ষ্যে উপজেলার প্রধান সড়ক ও শিক্ষাপ্রতিষ্ঠান প্রাঙ্গণে ফলজ, বনজ ও ঔষধি বৃক্ষরোপণ কর্মসূচি পরিচালিত হবে।</p>',
            ]);

            Event::create([
                'title' => 'ফ্রি মেডিকেল ক্যাম্প',
                'thumbnail' => 'assets/images/event-3.jpg',
                'date' => '2026-11-25',
                'time' => 'সকাল ৯:০০',
                'location' => 'শৈলকুপা স্বাস্থ্য কমপ্লেক্স',
                'status' => 'active',
                'order_index' => 3,
                'description' => '<p><strong>ফ্রি মেডিকেল ক্যাম্প</strong></p><p>অসহায় ও সুবিধাবঞ্চিত মানুষদের জন্য অভিজ্ঞ বিশেষজ্ঞ চিকিৎসকদের দ্বারা বিনামূল্যে স্বাস্থ্য পরীক্ষা, পরামর্শ এবং জরুরি ওষুধ বিতরণ কর্মসূচি।</p>',
            ]);
        }
    }
}
