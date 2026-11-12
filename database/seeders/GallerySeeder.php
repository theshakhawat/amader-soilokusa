<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        if (GalleryItem::count() === 0) {
            // Photos
            GalleryItem::create([
                'type' => 'photo',
                'title' => 'বৃক্ষরোপণ কর্মসূচি ২০২৬',
                'file_path' => 'assets/images/event-2.jpg',
                'status' => true,
                'order_index' => 1,
            ]);

            GalleryItem::create([
                'type' => 'photo',
                'title' => 'শিক্ষা বৃত্তি বিতরণ অনুষ্ঠান',
                'file_path' => 'assets/images/event-1.jpg',
                'status' => true,
                'order_index' => 2,
            ]);

            GalleryItem::create([
                'type' => 'photo',
                'title' => 'ফ্রি মেডিকেল ও হেলথ ক্যাম্প',
                'file_path' => 'assets/images/event-3.jpg',
                'status' => true,
                'order_index' => 3,
            ]);

            GalleryItem::create([
                'type' => 'photo',
                'title' => 'ঐতিহাসিক শৈলকুপা শাহী মসজিদ প্রাঙ্গণ',
                'file_path' => 'assets/images/banner-3.jpg',
                'status' => true,
                'order_index' => 4,
            ]);

            // Videos
            GalleryItem::create([
                'type' => 'video',
                'title' => 'আগামীর শৈলকুপা পরিচিতি ও তথ্যচিত্র',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'status' => true,
                'order_index' => 1,
            ]);

            GalleryItem::create([
                'type' => 'video',
                'title' => 'বার্ষিক সাধারণ সভা ও স্বেচ্ছাসেবী সম্মেলন',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'status' => true,
                'order_index' => 2,
            ]);
        }
    }
}

