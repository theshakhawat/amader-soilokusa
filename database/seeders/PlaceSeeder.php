<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\PlacePhoto;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $demoPlaces = [
            [
                'title' => 'ঐতিহাসিক শৈলকুপা শাহী মসজিদ',
                'subtitle' => 'সুলতানি আমলের অনবদ্য স্থাপত্যশৈলী ও প্রাচীন নিদর্শন',
                'thumbnail' => 'assets/images/place-mosque.jpg',
                'location' => 'শৈলকুপা বাজার সংলগ্ন, ঝিনাইদহ',
                'descriptions' => '<p><strong>শৈলকুপা শাহী মসজিদ</strong> ঝিনাইদহ জেলার শৈলকুপা উপজেলায় অবস্থিত একটি অন্যতম প্রাচীন ঐতিহাসিক প্রত্নতাত্ত্বিক নিদর্শন। আনুমানিক সুলতানি আমলে কুমার নদের তীরে এ মসজিদটি নির্মিত হয়।</p><p>মসজিদের চারকোণে চারটি বিরাট অষ্টকোণাকৃতির মিনার ও অপূর্ব টেরাকোটা অলংকরণ রয়েছে যা তৎকালীন বাংলার সমৃদ্ধ স্থাপত্যের পরিচয় বহন করে। দেশ-বিদেশের বহু পর্যটক ও দর্শনার্থী প্রতিদিন এই পবিত্র ও ঐতিহাসিক স্থানটি দর্শন করতে আসেন।</p><p><strong>কিভাবে যাবেন:</strong> ঝিনাইদহ জেলা শহর থেকে বাস কিংবা সিএনজি যোগে শৈলকুপা সদরে পৌঁছে রিকশা বা ভ্যানে ৫ মিনিটেই মসজিদে যাওয়া যায়।</p>',
                'status' => true,
                'order_index' => 1,
                'photos' => [
                    'assets/images/place-mosque.jpg',
                    'assets/images/hero-shailkupa.jpg',
                    'assets/images/about-shaheed-minar.jpg',
                ],
            ],
            [
                'title' => 'কুমার ও গড়াই নদী তীর',
                'subtitle' => 'নয়নাভিরাম প্রাকৃতিক সৌন্দর্য ও সূর্যাস্তের মনোরম দৃশ্য',
                'thumbnail' => 'assets/images/hero-shailkupa.jpg',
                'location' => 'কুমার নদের পাড়, শৈলকুপা',
                'descriptions' => '<p>শৈলকুপার বুক চিরে বয়ে চলা কুমার নদ ও গড়াই নদীর অববাহিকা চিরসবুজ শান্ত পরিবেশ ও নৈসর্গিক রূপের জন্য দর্শনার্থীদের মন কাড়ে। বিশেষ করে বিকেল বেলা নদীর পাড়ে হেঁটে সূর্যাস্ত উপভোগ করা স্থানীয় ও ভ্রমণপিপাসুদের অন্যতম প্রিয় বিনোদন।</p><p>নদীতে নৌভ্রমণ এবং জেলেদের মাছ ধরার দৃশ্য এক অনন্য গ্রাম-বাংলার আবহ তৈরি করে।</p>',
                'status' => true,
                'order_index' => 2,
                'photos' => [
                    'assets/images/hero-shailkupa.jpg',
                    'assets/images/project-road.jpg',
                ],
            ],
            [
                'title' => 'কবিরপুর প্রাচীন জমিদার বাড়ি',
                'subtitle' => 'ঐতিহাসিক স্থাপত্য ও শতবর্ষী প্রাচীন ঐতিহ্য',
                'thumbnail' => 'assets/images/about-shaheed-minar.jpg',
                'location' => 'কবিরপুর, শৈলকুপা',
                'descriptions' => '<p>কবিরপুর প্রাচীন জমিদার বাড়ি শৈলকুপার অন্যতম প্রত্নতাত্ত্বিক ও দৃষ্টিনন্দন স্থাপনা। তৎকালীন জমিদারদের সুরম্য অট্টালিকা, কারুকার্যখচিত প্রবেশদ্বার ও সুবিশাল দীঘি প্রাচীন ইতিহাসের এক জলজ্যান্ত সাক্ষী।</p><p>ইতিহাসপ্রেমী ভ্রমণকারীদের কাছে এই স্থানটি বিশেষভাবে আকর্ষণীয়।</p>',
                'status' => true,
                'order_index' => 3,
                'photos' => [
                    'assets/images/about-shaheed-minar.jpg',
                    'assets/images/place-mosque.jpg',
                ],
            ],
        ];

        foreach ($demoPlaces as $item) {
            $photos = $item['photos'] ?? [];
            unset($item['photos']);

            $place = Place::updateOrCreate(
                ['title' => $item['title']],
                $item
            );

            // Seed photos if not present
            if ($place->photos()->count() === 0) {
                foreach ($photos as $idx => $photoPath) {
                    PlacePhoto::create([
                        'place_id' => $place->id,
                        'image' => $photoPath,
                        'order_index' => $idx + 1,
                    ]);
                }
            }
        }
    }
}

