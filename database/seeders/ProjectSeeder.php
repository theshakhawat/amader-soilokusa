<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectPhoto;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Project::count() > 0) {
            return;
        }

        $projects = [
            [
                'title' => 'গ্রামীণ সড়ক সংস্কার ও কালভার্ট নির্মাণ প্রকল্প',
                'slug' => 'rural-road-renovation-project',
                'thumbnail' => 'assets/images/project-road.jpg',
                'project_status' => 'running',
                'description' => '<h2>গ্রামীণ সড়ক সংস্কার ও টেকসই যোগাযোগ ব্যবস্থা উন্নয়ন</h2><p>শৈলকুপা উপজেলার দুর্গম ও অবহেলিত গ্রামীণ জনপদের সাধারণ মানুষের যাতায়াত নির্বিঘ্ন করতে আগামীর শৈলকুপার উদ্যোগে শুরু হয়েছে <strong>গ্রামীণ সড়ক সংস্কার ও কালভার্ট নির্মাণ প্রকল্প</strong>।</p><ul><li>১০ কিলোমিটার কাঁচা রাস্তা পাকাকরণ ও সংস্কার</li><li>৪টি জরুরি কালভার্ট পুনঃনির্মাণ</li><li>বর্ষা মৌসুমে জলাবদ্ধতা নিরসনে ড্রেনেজ উন্নয়ন</li></ul><p>এই প্রকল্পের ফলে স্থানীয় কৃষক ও ছাত্রছাত্রীরা সারা বছর নিরাপদে চলাচল করতে পারছে।</p>',
                'status' => true,
                'order_index' => 1,
                'photos' => [
                    'assets/images/project-road.jpg',
                    'assets/images/event-1.jpg',
                    'assets/images/event-2.jpg',
                ],
            ],
            [
                'title' => 'বিশুদ্ধ খাবার পানির গভীর নলকূপ ও ফিল্টারেশন প্ল্যান্ট স্থাপন',
                'slug' => 'safe-drinking-water-filtration-plant',
                'thumbnail' => 'assets/images/event-3.jpg',
                'project_status' => 'running',
                'description' => '<h2>সুপেয় পানি নিশ্চিতকরণ কর্মসূচি</h2><p>শৈলকুপার বিভিন্ন ইউনিয়নে আর্সেনিকমুক্ত নিরাপদ খাবার পানির তীব্র সংকট নিরসনে সৌরবিদ্যুৎ চালিত গভীর নলকূপ ও পানি শোধনাগার স্থাপন কাজ চলমান রয়েছে।</p><p>প্রতিটি প্ল্যান্ট থেকে দৈনিক গড়ে ৫০০ পরিবার সুপেয় পানি সংগ্রহ করতে পারছে। স্বাস্থ্যঝুঁকি কমাতে এই প্রকল্প একটি যুগান্তকারী পদক্ষেপ।</p>',
                'status' => true,
                'order_index' => 2,
                'photos' => [
                    'assets/images/event-3.jpg',
                    'assets/images/event-1.jpg',
                ],
            ],
            [
                'title' => 'ডিজিটাল পাঠাগার ও যুব কম্পিউটার প্রশিক্ষণ কেন্দ্র',
                'slug' => 'digital-library-youth-computer-training-center',
                'thumbnail' => 'assets/images/event-1.jpg',
                'project_status' => 'completed',
                'description' => '<h2>শৈলকুপা যুবসমাজের দক্ষতা বৃদ্ধি ও আত্মকর্মসংস্থান</h2><p>আধুনিক তথ্যপ্রযুক্তির যুগে যুবসমাজকে দক্ষ মানবসম্পদে রূপান্তর করতে শৈলকুপা সদরে সফলভাবে চালু করা হয়েছে ডিজিটাল পাঠাগার ও আইসিটি প্রশিক্ষণ ল্যাব।</p><p>ইতিমধ্যে প্রথম ব্যাচের ৫০ জন তরুণ ফ্রিল্যান্সিং ও অফিস ম্যানেজমেন্ট প্রশিক্ষণ সফলভাবে সম্পন্ন করেছে।</p>',
                'status' => true,
                'order_index' => 3,
                'photos' => [
                    'assets/images/event-1.jpg',
                    'assets/images/event-2.jpg',
                ],
            ],
            [
                'title' => 'সবুজ শৈলকুপা: ৫০ হাজার ফলদ ও বনজ বৃক্ষরোপণ কর্মসূচি',
                'slug' => 'green-shailkupa-tree-plantation-project',
                'thumbnail' => 'assets/images/event-2.jpg',
                'project_status' => 'completed',
                'description' => '<h2>পরিবেশ রক্ষা ও জলবায়ু পরিবর্তন মোকাবেলা</h2><p>উপজেলার বিভিন্ন শিক্ষা প্রতিষ্ঠান, সড়ক ও বাঁধের দুই পাশে ৫০ হাজার পরিবেশবান্ধব গাছ রোপণ ও পরিচর্যার লক্ষ্য নিয়ে এ প্রকল্প বাস্তবায়ন সম্পন্ন হয়েছে।</p>',
                'status' => true,
                'order_index' => 4,
                'photos' => [
                    'assets/images/event-2.jpg',
                    'assets/images/project-road.jpg',
                ],
            ],
        ];

        foreach ($projects as $item) {
            $photos = $item['photos'];
            unset($item['photos']);

            $project = Project::create($item);

            foreach ($photos as $idx => $photo) {
                ProjectPhoto::create([
                    'project_id' => $project->id,
                    'image_path' => $photo,
                    'caption' => $project->title . ' - ছবি ' . ($idx + 1),
                    'order_index' => $idx + 1,
                ]);
            }
        }
    }
}

