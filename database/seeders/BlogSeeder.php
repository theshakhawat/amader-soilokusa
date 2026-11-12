<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesData = [
            ['name' => 'উন্নয়ন ভাবনা', 'slug' => 'development-vision', 'status' => true],
            ['name' => 'শিক্ষা ও গবেষণা', 'slug' => 'education-research', 'status' => true],
            ['name' => 'ঐতিহ্য ও সংস্কৃতি', 'slug' => 'heritage-culture', 'status' => true],
            ['name' => 'কৃষি ও পরিবেশ', 'slug' => 'agriculture-environment', 'status' => true],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        $postsData = [
            [
                'category_id' => $categories['development-vision']->id,
                'title'       => 'শৈলকুপার সম্ভাবনা ও উন্নয়নের রূপকল্প',
                'slug'        => 'shailkupa-potential-and-development-vision',
                'thumbnail'   => 'assets/images/blog-1.jpg',
                'content'     => '<p>কৃষিপ্রধান শৈলকুপা উপজেলার গ্রামীণ অর্থনীতি, ক্ষুদ্র শিল্প ও তরুণ সমাজের কর্মসংস্থান বৃদ্ধির মাধ্যমে একটি আধুনিক জনপদ গড়ে তোলার দীর্ঘমেয়াদী রূপকল্প নিয়ে আগামীর শৈলকুপা কাজ করছে।</p><p>আমাদের প্রধান লক্ষ্য হলো আধুনিক অবকাঠামো, স্বাস্থ্যসেবার আধুনিকায়ন এবং টেকসই যোগাযোগ নেটওয়ার্ক তৈরি করা।</p>',
                'status'      => true,
                'published'   => '2026-11-01 10:00:00',
            ],
            [
                'category_id' => $categories['education-research']->id,
                'title'       => 'শিক্ষার মানোন্নয়নে আমাদের পরিকল্পনা',
                'slug'        => 'our-plans-for-improving-education-quality',
                'thumbnail'   => 'assets/images/blog-2.jpg',
                'content'     => '<p>উপজেলার প্রতিটি বিদ্যালয়ে মানসম্মত শিক্ষা নিশ্চিতকরণ, ডিজিটাল ল্যাব সুবিধা বৃদ্ধি এবং ঝরে পড়া শিক্ষার্থীদের বিদ্যালয়মুখী করার সমন্বিত উদ্যোগ গ্রহণ করা হয়েছে।</p><p>মেধাবী শিক্ষার্থীদের বৃত্তি প্রদান ও ক্যারিয়ার নির্দেশনামূলক কর্মশালার নিয়মিত আয়োজন করা হচ্ছে।</p>',
                'status'      => true,
                'published'   => '2026-10-28 09:30:00',
            ],
            [
                'category_id' => $categories['heritage-culture']->id,
                'title'       => 'শৈলকুপার ঐতিহ্য, প্রকৃতি ও সংস্কৃতি',
                'slug'        => 'shailkupa-heritage-nature-culture',
                'thumbnail'   => 'assets/images/blog-3.jpg',
                'content'     => '<p>কুমার নদ ও গড়াই নদীর অববাহিকায় গড়ে ওঠা শৈলকুপার রয়েছে শতাব্দী প্রাচীন সমৃদ্ধ ইতিহাস ও অনুপম লোকসংস্কৃতি।</p><p>সুলতানি আমলের ঐতিহাসিক শৈলকুপা শাহী মসজিদ এবং প্রাচীন জমিদার বাড়ির স্থাপত্য শৈলী আমাদের গর্বিত অতীতের স্বাক্ষর বহন করে।</p>',
                'status'      => true,
                'published'   => '2026-10-20 16:00:00',
            ],
        ];

        foreach ($postsData as $post) {
            Post::updateOrCreate(
                ['title' => $post['title']],
                $post
            );
        }
    }
}
