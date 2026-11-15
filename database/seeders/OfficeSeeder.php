<?php

namespace Database\Seeders;

use App\Models\Office;
use App\Models\OfficeMember;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices = [
            [
                'name'        => 'উপজেলা নির্বাহী অফিসারের কার্যালয় (UNO অফিস)',
                'slug'        => 'uno-office',
                'location'    => 'উপজেলা পরিষদ ভবন, শৈলকূপা, ঝিনাইদহ',
                'image'       => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=1200&q=80',
                'description' => '<p><strong>উপজেলা নির্বাহী অফিসারের কার্যালয়, শৈলকূপা</strong> উপজেলার সামগ্রিক প্রশাসনিক কার্যক্রম, আইন-শৃঙ্খলা সমন্বয়, দুর্যোগ ব্যবস্থাপনা এবং সরকারের বিভিন্ন উন্নয়নমূলক প্রকল্পের তত্ত্বাবধান করে থাকে। এটি উপজেলার মূল প্রশাসনিক কেন্দ্রবিন্দু হিসেবে দায়িত্ব পালন করছে।</p><h3>প্রধান সেবাসমূহ:</h3><ul><li>উপজেলা পর্যায়ের প্রশাসনিক সমন্বয় ও তদারকি</li><li>নাগরিক সনদ ও সরকারি প্রত্যয়নপত্র যাচাই</li><li>সামাজিক সুরক্ষা ও ত্রাণ কার্যক্রম পরিচালনা</li><li>মোবাইল কোর্ট পরিচালনা ও আইন-শৃঙ্খলা রক্ষা</li></ul>',
                'order'       => 1,
                'members'     => [
                    [
                        'name'          => 'স্নীগ্ধা দাস',
                        'designation'   => 'উপজেলা নির্বাহী অফিসার (ইউএনও)',
                        'qualification' => 'বিসিএস (প্রশাসন ক্যাডার), এম.এস-সি',
                        'phone'         => '01711002233',
                        'email'         => 'unoshailkupa@mopa.gov.bd',
                    ],
                    [
                        'name'          => 'মোঃ আবুল বাশার',
                        'designation'   => 'প্রশাসনিক কর্মকর্তা (AO)',
                        'qualification' => 'বি.এ (অনার্স), এম.এ',
                        'phone'         => '01711223344',
                        'email'         => 'ao.unoshailkupa@gmail.com',
                    ],
                    [
                        'name'          => 'মোছাঃ শারমিন আক্তার',
                        'designation'   => 'উপজেলা আইসিটি অফিসার',
                        'qualification' => 'বি.এস-সি ইন সিএসই',
                        'phone'         => '01711445566',
                        'email'         => 'ict.shailkupa@doict.gov.bd',
                    ],
                ],
            ],
            [
                'name'        => 'উপজেলা কৃষি অফিস, শৈলকূপা',
                'slug'        => 'agriculture-office',
                'location'    => 'কৃষি ভবন, উপজেলা পরিষদ চত্বর, শৈলকূপা',
                'image'       => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1200&q=80',
                'description' => '<p>শৈলকূপা উপজেলা কৃষি সম্প্রসারণ অধিদপ্তর কৃষকদের আধুনিক চাষাবাদ প্রযুক্তি, উন্নত বীজ, সার ও বালাইনাশক ব্যবহারে সার্বক্ষণিক পরামর্শ ও সেবা প্রদান করে থাকে। বিশেষ করে পেঁয়াজ, পাট ও ধান উৎপাদনে উপজেলার কৃষকদের সমৃদ্ধ করতে বিভিন্ন প্রণোদনা কর্মসূচি পরিচালিত হয়।</p>',
                'order'       => 2,
                'members'     => [
                    [
                        'name'          => 'কৃষিবিদ ড. মোঃ মহসীন আলী',
                        'designation'   => 'উপজেলা কৃষি অফিসার (ইউএও)',
                        'qualification' => 'বি.এস-সি এজি (অনার্স), এম.এস, পিএইচ.ডি',
                        'phone'         => '01712003344',
                        'email'         => 'uao.shailkupa@dae.gov.bd',
                    ],
                    [
                        'name'          => 'কৃষিবিদ মোঃ আশরাফুল কবির',
                        'designation'   => 'কৃষি সম্প্রসারণ কর্মকর্তা',
                        'qualification' => 'বি.এস-সি এজি (সম্মান)',
                        'phone'         => '01712224455',
                        'email'         => 'aeo.shailkupa@gmail.com',
                    ],
                    [
                        'name'          => 'মোঃ রফিকুল ইসলাম',
                        'designation'   => 'উপসহকারী কৃষি কর্মকর্তা',
                        'qualification' => 'ডিপ্লোমা ইন এগ্রিকালচার',
                        'phone'         => '01712445566',
                        'email'         => 'saao.shailkupa@gmail.com',
                    ],
                ],
            ],
            [
                'name'        => 'শৈলকূপা থানা / পুলিশ অফিস',
                'slug'        => 'police-office',
                'location'    => 'থানা রোড, শৈলকূপা পৌরসভা, ঝিনাইদহ',
                'image'       => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=1200&q=80',
                'description' => '<p>শৈলকূপা উপজেলার ১৪টি ইউনিয়ন ও পৌর এলাকায় শান্তি-শৃঙ্খলা রক্ষা, অপরাধ দমন, ট্রাফিক নিয়ন্ত্রণ এবং নাগরিকদের সার্বিক নিরাপত্তা বিধানে ২৪ ঘণ্টা দায়িত্ব পালন করে শৈলকূপা থানা পুলিশ।</p><h3>জরুরি পুলিশি সেবা:</h3><ul><li>জিডি ও মামলা দায়ের সুবিধা</li><li>জরুরি সেবা: ৯৯৯</li><li>বিট পুলিশিং ও কমিউনিটি পুলিশিং সেবা</li></ul>',
                'order'       => 3,
                'members'     => [
                    [
                        'name'          => 'মোঃ শফিকুল ইসলাম চৌধুরী',
                        'designation'   => 'অফিসার ইনচার্জ (ওসি)',
                        'qualification' => 'বি.এ (অনার্স), এম.এ',
                        'phone'         => '01713374245',
                        'email'         => 'oc.shailkupa@police.gov.bd',
                    ],
                    [
                        'name'          => 'মোঃ তানভীর হাসান',
                        'designation'   => 'পুলিশ পরিদর্শক (তদন্ত)',
                        'qualification' => 'এলএল.বি (সম্মান)',
                        'phone'         => '01713374246',
                        'email'         => 'investigation.shailkupa@police.gov.bd',
                    ],
                    [
                        'name'          => 'এসআই আনিসুর রহমান',
                        'designation'   => 'সেকেন্ড অফিসার',
                        'qualification' => 'বি.এস-সি',
                        'phone'         => '01713374247',
                        'email'         => 'si.anis.shailkupa@gmail.com',
                    ],
                ],
            ],
            [
                'name'        => 'উপজেলা স্বাস্থ্য কমপ্লেক্স, শৈলকূপা',
                'slug'        => 'health-complex',
                'location'    => 'হাসপাতাল রোড, শৈলকূপা পৌরসভা, ঝিনাইদহ',
                'image'       => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=1200&q=80',
                'description' => '<p>৫০ শয্যাবিশিষ্ট শৈলকূপা উপজেলা স্বাস্থ্য কমপ্লেক্স এলাকার সাধারণ মানুষের প্রাথমিক ও বিশেষায়িত স্বাস্থ্যসেবায় নিয়োজিত। জরুরি বিভাগ, বহির্বিভাগ, অন্তর্বিভাগ, প্যাথলজিক্যাল পরীক্ষা এবং বিনামূল্যে সরকারি ওষুধ বিতরণ কার্যক্রম চালু রয়েছে।</p>',
                'order'       => 4,
                'members'     => [
                    [
                        'name'          => 'ডাঃ মোঃ রাশেদুল ইসলাম',
                        'designation'   => 'উপজেলা স্বাস্থ্য ও পরিবার পরিকল্পনা কর্মকর্তা (UH&FPO)',
                        'qualification' => 'এমবিবিএস, বিসিএস (স্বাস্থ্য), এমপিএইচ',
                        'phone'         => '01714005566',
                        'email'         => 'shailkupa@uhfpo.dghs.gov.bd',
                    ],
                    [
                        'name'          => 'ডাঃ নাজমুন নাহার',
                        'designation'   => 'আবাসিক মেডিকেল অফিসার (RMO)',
                        'qualification' => 'এমবিবিএস, এফসিপিএস (পার্ট-১)',
                        'phone'         => '01714226677',
                        'email'         => 'rmo.shailkupa@gmail.com',
                    ],
                ],
            ],
            [
                'name'        => 'উপজেলা ভূমি অফিস (এসি ল্যান্ড অফিস)',
                'slug'        => 'land-office',
                'location'    => 'ভূমি অফিস চত্বর, শৈলকূপা পৌরসভা',
                'image'       => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&q=80',
                'description' => '<p>নামজারি (মিউটেশন), ভূমি উন্নয়ন কর আদায়, খাসজমি বন্দোবস্ত ও ভূমি সম্পর্কিত বিরোধ নিরসনে কাজ করে সহকারী কমিশনার (ভূমি)-এর কার্যালয়। সম্পূর্ণ ডিজিটাল ই-নামজারি সেবার মাধ্যমে দ্রুত সেবা প্রদান করা হয়।</p>',
                'order'       => 5,
                'members'     => [
                    [
                        'name'          => 'মোঃ আরিফুজ্জামান',
                        'designation'   => 'সহকারী কমিশনার (ভূমি)',
                        'qualification' => 'বিসিএস (প্রশাসন ক্যাডার), এম.এস-সি',
                        'phone'         => '01715006677',
                        'email'         => 'aclandshailkupa@mopa.gov.bd',
                    ],
                    [
                        'name'          => 'মোঃ জাহাঙ্গীর আলম',
                        'designation'   => 'কানুনগো',
                        'qualification' => 'ডিপ্লোমা ইন সার্ভে অ্যান্ড ল্যান্ড লজ',
                        'phone'         => '01715227788',
                        'email'         => 'kanungo.shailkupa@gmail.com',
                    ],
                ],
            ],
            [
                'name'        => 'অন্যান্য সরকারি অফিসসমূহ (উপজেলা সমাজসেবা কার্যালয়)',
                'slug'        => 'social-service-office',
                'location'    => 'উপজেলা পরিষদ ভবন (২য় তলা), শৈলকূপা',
                'image'       => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200&q=80',
                'description' => '<p>বয়স্ক ভাতা, বিধবা ভাতা, অসচ্ছল প্রতিবন্ধী ভাতা, সুদমুক্ত ক্ষুদ্রঋণ এবং এতিম-অসহায় জনগোষ্ঠীর কল্যাণে সমাজকল্যাণ মন্ত্রণালয়ের অধীনে কাজ করে থাকে এই কার্যালয়।</p>',
                'order'       => 6,
                'members'     => [
                    [
                        'name'          => 'মোঃ তৌহিদুর রহমান',
                        'designation'   => 'উপজেলা সমাজসেবা অফিসার',
                        'qualification' => 'বি.এস-সি, এম.এস-সি (সমাজবিজ্ঞান)',
                        'phone'         => '01716007788',
                        'email'         => 'usso.shailkupa@dss.gov.bd',
                    ],
                ],
            ],
        ];

        foreach ($offices as $data) {
            $members = $data['members'] ?? [];
            unset($data['members']);

            $office = Office::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            // Re-seed members cleanly
            $office->members()->delete();
            foreach ($members as $mIdx => $m) {
                OfficeMember::create([
                    'office_id'     => $office->id,
                    'name'          => $m['name'],
                    'designation'   => $m['designation'],
                    'qualification' => $m['qualification'] ?? null,
                    'phone'         => $m['phone'] ?? null,
                    'email'         => $m['email'] ?? null,
                    'photo'         => null,
                    'order'         => $mIdx + 1,
                ]);
            }
        }
    }
}

