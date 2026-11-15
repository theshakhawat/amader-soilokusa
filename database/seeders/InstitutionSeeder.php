<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\InstitutionCategory;
use App\Models\InstitutionImage;
use App\Models\InstitutionMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // ==============================================================
            // ১. ইউনিভার্সিটি (উচ্চশিক্ষা প্রতিষ্ঠান)
            // ==============================================================
            [
                'category' => [
                    'name'   => 'ইউনিভার্সিটি',
                    'slug'   => 'university',
                    'status' => true,
                ],
                'institutions' => [
                    [
                        'name'        => 'ইসলামী বিশ্ববিদ্যালয় (শৈলকূপা সংলগ্ন প্রধান ক্যাম্পাস)',
                        'slug'        => 'islamic-university-kushtia-jhenaidah',
                        'location'    => 'শান্তিডাঙ্গা-দুলালপুর, শৈলকূপা সীমানা সংলগ্ন',
                        'description' => '<p><strong>ইসলামী বিশ্ববিদ্যালয়</strong> শৈলকূপা উপজেলার সন্নিকটে অবস্থিত বাংলাদেশের দক্ষিণ-পশ্চিমাঞ্চলের সর্বোচ্চ বিদ্যাপীঠ। ১৯৭৯ সালে প্রতিষ্ঠিত এই বিশ্ববিদ্যালয়টি উচ্চশিক্ষা ও গবেষণায় জাতীয় ও আন্তর্জাতিক পর্যায়ে এক অনন্য ভূমিকা পালন করে আসছে।</p><p>শৈলকূপার হাজারো শিক্ষার্থী এই বিশ্ববিদ্যালয় থেকে উচ্চতর ডিগ্রি অর্জন করে দেশ ও বিদেশে নেতৃত্ব দিচ্ছেন। ক্যাম্পাসে ৮টি অনুষদের অধীনে ৩৬টি বিভাগ চালু রয়েছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=1200&q=80',
                            'https://images.unsplash.com/photo-1562774053-701939374585?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'প্রফেসর ড. শেখ আবদুস সালাম',
                                'designation'   => 'উপাচার্য (সাবেক)',
                                'qualification' => 'পিএইচ.ডি, এম.এস-সি',
                                'phone'         => '01711000101',
                                'email'         => 'vc@iu.ac.bd',
                            ],
                            [
                                'name'          => 'প্রফেসর ড. মোঃ মাহবুবুর রহমান',
                                'designation'   => 'উপ-উপাচার্য',
                                'qualification' => 'এম.ফিল, পিএইচ.ডি',
                                'phone'         => '01711000102',
                                'email'         => 'pro_vc@iu.ac.bd',
                            ],
                            [
                                'name'          => 'এইচ. এম. আলী হাসান',
                                'designation'   => 'রেজিস্ট্রার (ভারপ্রাপ্ত)',
                                'qualification' => 'এম.এ (লোকপ্রশাসন)',
                                'phone'         => '01711000103',
                                'email'         => 'registrar@iu.ac.bd',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'বাংলাদেশ উন্মুক্ত বিশ্ববিদ্যালয় (বাউবি) শৈলকূপা স্টাডি সেন্টার',
                        'slug'        => 'bou-study-center-shailkupa',
                        'location'    => 'শৈলকূপা সরকারি ডিগ্রি কলেজ ক্যাম্পাস, শৈলকূপা',
                        'description' => '<p>দূরশিক্ষণ ও উন্মুক্ত শিক্ষার সুযোগ সম্প্রসারণের লক্ষ্যে শৈলকূপায় বাংলাদেশ উন্মুক্ত বিশ্ববিদ্যালয়ের স্টাডি সেন্টারটি দীর্ঘদিন ধরে পরিচালিত হয়ে আসছে। কর্মজীবী ও প্রান্তিক জনগোষ্ঠীর মাঝে উচ্চশিক্ষা পৌঁছে দিতে এ কেন্দ্রটি অগ্রণী ভূমিকা রাখছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'প্রফেসর মোঃ আব্দুল ওহাব',
                                'designation'   => 'সমন্বয়কারী (বাউবি শৈলকূপা)',
                                'qualification' => 'এম.এ, বি.সি.এস (সাধারণ শিক্ষা)',
                                'phone'         => '01712111222',
                                'email'         => 'bou.shailkupa@gmail.com',
                            ],
                            [
                                'name'          => 'মোঃ তৌহিদুল ইসলাম',
                                'designation'   => 'সহকারী সমন্বয়ক',
                                'qualification' => 'এম.এস-সি',
                                'phone'         => '01712333444',
                                'email'         => 'touhid.bou@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'শেখ কামাল আইটি ট্রেনিং অ্যান্ড ইনকিউবেশন সেন্টার',
                        'slug'        => 'sheikh-kamal-it-training-center-shailkupa',
                        'location'    => 'উপজেলা পরিষদ চত্বর, শৈলকূপা পৌরসভা',
                        'description' => '<p>শৈলকূপার তরুণ প্রজন্মকে আধুনিক তথ্যপ্রযুক্তি ও ফ্রিল্যান্সিংয়ে দক্ষ করে তুলতে উচ্চতর প্রযুক্তি শিক্ষা ও ইনকিউবেশন সুবিধা প্রদান করছে এই প্রতিষ্ঠানটি।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'প্রকৌশলী তানভীর হোসেন',
                                'designation'   => 'ক্যাম্পাস ইনচার্জ ও পরিচালক',
                                'qualification' => 'বি.এস-সি ইন সিএসই (বুয়েট)',
                                'phone'         => '01713555666',
                                'email'         => 'incharge.it@shailkupa.gov.bd',
                            ],
                            [
                                'name'          => 'সাবরিনা সুলতানা',
                                'designation'   => 'সফটওয়্যার ট্রেইনার ও মেন্টর',
                                'qualification' => 'এম.এস-সি ইন আইটি',
                                'phone'         => '01713777888',
                                'email'         => 'sabrina.trainer@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'জাতীয় বিশ্ববিদ্যালয় শৈলকূপা আঞ্চলিক পরীক্ষা ও সমন্বয় সেল',
                        'slug'        => 'national-university-coordination-cell-shailkupa',
                        'location'    => 'শৈলকূপা কলেজ রোড, শৈলকূপা',
                        'description' => '<p>শৈলকূপা উপজেলার সকল ডিগ্রি ও অনার্স শিক্ষার্থীদের প্রশাসনিক কাজ ও পরীক্ষার সমন্বয় সাধনের জন্য এই কেন্দ্রটি দায়িত্ব পালন করে থাকে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'ড. আহমেদ কামাল',
                                'designation'   => 'আঞ্চলিক সমন্বয়ক',
                                'qualification' => 'এম.ফিল, পিএইচ.ডি',
                                'phone'         => '01714888999',
                                'email'         => 'nu.coordinator@shailkupa.edu.bd',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'ঝিনাইদহ সরকারি ভেটেরিনারি কলেজ (বিশ্ববিদ্যালয় সমমান অনুষদ)',
                        'slug'        => 'jhenaidah-government-veterinary-college',
                        'location'    => 'চুয়াডাঙ্গা-ঝিনাইদহ মহাসড়ক, শৈলকূপা ট্রানজিট',
                        'description' => '<p>পশুপালন ও ভেটেরিনারি বিজ্ঞানে উচ্চশিক্ষার জন্য এই উচ্চশিক্ষা প্রতিষ্ঠানটি শৈলকূপা ও সমগ্র দক্ষিণ-পশ্চিমাঞ্চলের শিক্ষার্থীদের অন্যতম প্রিয় প্রতিষ্ঠান।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'প্রফেসর ড. অসিত কুমার রায়',
                                'designation'   => 'অধ্যক্ষ ও অনুষদ প্রধান',
                                'qualification' => 'ডিভিএম, এম.এস, পিএইচ.ডি',
                                'phone'         => '01715000111',
                                'email'         => 'principal@jgvc.ac.bd',
                            ],
                            [
                                'name'          => 'ড. রফিকুল ইসলাম',
                                'designation'   => 'সহযোগী অধ্যাপক',
                                'qualification' => 'ডিভিএম, এম.এস',
                                'phone'         => '01715222333',
                                'email'         => 'dr.rafiq@jgvc.ac.bd',
                            ],
                        ],
                    ],
                ],
            ],

            // ==============================================================
            // ২. কলেজ (College)
            // ==============================================================
            [
                'category' => [
                    'name'   => 'কলেজ',
                    'slug'   => 'college',
                    'status' => true,
                ],
                'institutions' => [
                    [
                        'name'        => 'শৈলকূপা সরকারি ডিগ্রি কলেজ',
                        'slug'        => 'shailkupa-government-degree-college',
                        'location'    => 'কলেজ রোড, শৈলকূপা পৌরসভা, ঝিনাইদহ',
                        'description' => '<p><strong>শৈলকূপা সরকারি ডিগ্রি কলেজ</strong> ১৯৬৯ সালে প্রতিষ্ঠিত শৈলকূপা উপজেলার সর্বপ্রাচীন ও প্রধান সরকারি মহাবিদ্যালয়। এটি উপজেলার উচ্চশিক্ষা বিস্তারে দীর্ঘ পাঁচ দশকেরও বেশি সময় ধরে অগ্রণী ভূমিকা পালন করে আসছে।</p><p>কলেজটিতে উচ্চ মাধ্যমিক ছাড়াও জাতীয় বিশ্ববিদ্যালয়ের অধীনে বিএ, বিএসএস, বিবিএস, বিএসসি ডিগ্রি (পাস) এবং একাধিক বিষয়ে স্নাতক (সম্মান/অনার্স) কোর্স চালু রয়েছে। সুবিশাল খেলার মাঠ, সমৃদ্ধ পাঠাগার ও বিজ্ঞানাগার রয়েছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1562774053-701939374585?w=1200&q=80',
                            'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'প্রফেসর মোঃ রেজাউল করিম',
                                'designation'   => 'অধ্যক্ষ (ভারপ্রাপ্ত)',
                                'qualification' => 'বি.সি.এস (সাধারণ শিক্ষা), এম.এ',
                                'phone'         => '01711234567',
                                'email'         => 'principal.sgdc@gmail.com',
                            ],
                            [
                                'name'          => 'মোঃ সাইদুর রহমান',
                                'designation'   => 'উপাধ্যক্ষ',
                                'qualification' => 'এম.এস-সি (গণিত)',
                                'phone'         => '01711987654',
                                'email'         => 'saidur.math@gmail.com',
                            ],
                            [
                                'name'          => 'ফারহানা পারভীন',
                                'designation'   => 'সহকারী অধ্যাপক (ইংরেজি)',
                                'qualification' => 'এম.এ (ইংরেজি সাহিত্য), বি.এড',
                                'phone'         => '01712345678',
                                'email'         => 'farhana.sgdc@gmail.com',
                            ],
                            [
                                'name'          => 'মোঃ নজরুল ইসলাম',
                                'designation'   => 'প্রভাষক (তথ্য ও যোগাযোগ প্রযুক্তি)',
                                'qualification' => 'বি.এস-সি ইন সিএসই',
                                'phone'         => '01713456789',
                                'email'         => 'nazrul.ict@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'শৈলকূপা মহিলা ডিগ্রি কলেজ',
                        'slug'        => 'shailkupa-mohila-degree-college',
                        'location'    => 'হাসপাতাল রোড, শৈলকূপা পৌরসভা, ঝিনাইদহ',
                        'description' => '<p>শৈলকূপা উপজেলায় নারী শিক্ষার প্রসারে ১৯৯৩ সালে প্রতিষ্ঠিত হয় <strong>শৈলকূপা মহিলা ডিগ্রি কলেজ</strong>। মনোরম ও সুরক্ষিত পরিবেশে এখানে উচ্চ মাধ্যমিক ও স্নাতক পর্যায়ের পাঠদান করা হয়।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোছাঃ নাসরিন আক্তার',
                                'designation'   => 'অধ্যক্ষ',
                                'qualification' => 'এম.এ (রাষ্ট্রবিজ্ঞান), বি.এড',
                                'phone'         => '01715678901',
                                'email'         => 'principal.smdc@gmail.com',
                            ],
                            [
                                'name'          => 'মোঃ রফিকুল ইসলাম',
                                'designation'   => 'উপাধ্যক্ষ',
                                'qualification' => 'এম.এস-সি (রসায়ন)',
                                'phone'         => '01716789012',
                                'email'         => 'rafiq.chem@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'শৈলকূপা সিটি কলেজ',
                        'slug'        => 'shailkupa-city-college',
                        'location'    => 'কবিরপুর, শৈলকূপা পৌরসভা, ঝিনাইদহ',
                        'description' => '<p>শৈলকূপা শহরের প্রাণকেন্দ্রে প্রতিষ্ঠিত এই কলেজটি মানসম্মত শিক্ষা ও সহশিক্ষা কার্যক্রমে অনন্য অবদান রেখে চলছে। বিজ্ঞান, মানবিক ও ব্যবসায় শিক্ষা শাখায় এখানে পাঠদান পরিচালিত হয়।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ গোলাম মোস্তফা',
                                'designation'   => 'অধ্যক্ষ',
                                'qualification' => 'এম.কম (হিসাববিজ্ঞান)',
                                'phone'         => '01717890123',
                                'email'         => 'mostafa.citycoll@gmail.com',
                            ],
                            [
                                'name'          => 'আনিসুর রহমান',
                                'designation'   => 'সহকারী অধ্যাপক (পদার্থবিজ্ঞান)',
                                'qualification' => 'এম.এস-সি',
                                'phone'         => '01718901234',
                                'email'         => 'anis.phy@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'কাঁচেরকোল সোনার বাংলা কলেজ',
                        'slug'        => 'kancherkol-sonar-bangla-college',
                        'location'    => 'কাঁচেরকোল বাজার, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>কাঁচেরকোল ইউনিয়নের শিক্ষার্থীদের উচ্চশিক্ষার স্বপ্ন পূরণে প্রতিষ্ঠিত সোনার বাংলা কলেজটি গ্রামীণ জনপদে শিক্ষার আলো ছড়িয়ে দিচ্ছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ আশরাফুল আলম',
                                'designation'   => 'অধ্যক্ষ',
                                'qualification' => 'এম.এ (ইতিহাস)',
                                'phone'         => '01719012345',
                                'email'         => 'ashraf.sbc@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'দিগনগর ডিগ্রি কলেজ',
                        'slug'        => 'dignagar-degree-college',
                        'location'    => 'দিগনগর বাজার, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>দিগনগর ডিগ্রি কলেজ শৈলকূপার উত্তর-পূর্বাঞ্চলের শিক্ষার্থীদের উচ্চ মাধ্যমিক ও ডিগ্রি পর্যায়ের শিক্ষা নিশ্চিতে নির্ভরযোগ্য বিদ্যাপীঠ।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ শাহজাহান আলী',
                                'designation'   => 'অধ্যক্ষ',
                                'qualification' => 'এম.এস-সি (পরিসংখ্যান)',
                                'phone'         => '01720123456',
                                'email'         => 'shahjahan.dnc@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'বেনীপুর টেকনিক্যাল অ্যান্ড বিএম কলেজ',
                        'slug'        => 'benipur-technical-and-bm-college',
                        'location'    => 'বেনীপুর বাজার, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>কারিগরি ও ব্যবসায় ব্যবস্থাপনা শিক্ষার প্রসারে বেনীপুর টেকনিক্যাল কলেজটি শৈলকূপার তরুণদের দক্ষ জনশক্তিতে রূপান্তর করছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'প্রকৌশলী মশিউর রহমান',
                                'designation'   => 'অধ্যক্ষ',
                                'qualification' => 'বি.এস-সি ইঞ্জিনিয়ারিং, ডিপ্লোমা',
                                'phone'         => '01721234567',
                                'email'         => 'moshiur.bm@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'হাকিমপুর আহসানিয়া কলেজ',
                        'slug'        => 'hakimpur-ahsania-college',
                        'location'    => 'হাকিমপুর, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>ঐতিহ্যবাহী হাকিমপুর আহসানিয়া কলেজটি মানবিক মূল্যবোধ ও নৈতিক শিক্ষার মাধ্যমে শিক্ষার্থীদের গড়ে তুলতে প্রতিশ্রুতিবদ্ধ।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মাওলানা মোঃ আব্দুল কাদের',
                                'designation'   => 'অধ্যক্ষ',
                                'qualification' => 'এম.এ (ইসলামের ইতিহাস)',
                                'phone'         => '01722345678',
                                'email'         => 'abdulqader.hac@gmail.com',
                            ],
                        ],
                    ],
                ],
            ],

            // ==============================================================
            // ৩. মাধ্যমিক বিদ্যালয় (Secondary School)
            // ==============================================================
            [
                'category' => [
                    'name'   => 'মাধ্যমিক বিদ্যালয়',
                    'slug'   => 'secondary-school',
                    'status' => true,
                ],
                'institutions' => [
                    [
                        'name'        => 'শৈলকূপা সরকারি পাইলট উচ্চ বিদ্যালয়',
                        'slug'        => 'shailkupa-government-pilot-high-school',
                        'location'    => 'থানা রোড, শৈলকূপা পৌরসভা, ঝিনাইদহ',
                        'description' => '<p><strong>শৈলকূপা সরকারি পাইলট উচ্চ বিদ্যালয়</strong> ১৮৯৩ সালে কুমার নদের তীরে প্রতিষ্ঠিত শৈলকূপার শ্রেষ্ঠ এবং শতাব্দীপ্রাচীন শিক্ষাপ্রতিষ্ঠান। এটি ২০১৮ সালে সরকারিকরণ করা হয়।</p><p>বিদ্যালয়টিতে সমৃদ্ধ আইসিটি ল্যাব, বিজ্ঞান গবেষণাগার ও সমৃদ্ধ লাইব্রেরি রয়েছে। জেএসসি ও এসএসসি পরীক্ষায় প্রতি বছর উপজেলার সর্বোচ্চ ফলাফল অর্জন করে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80',
                            'https://images.unsplash.com/photo-1562774053-701939374585?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ হাসানুজ্জামান',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'এম.এস-সি (গণিত), বি.এড',
                                'phone'         => '01713111222',
                                'email'         => 'headmaster.sgphs@gmail.com',
                            ],
                            [
                                'name'          => 'অরুণ কুমার সেন',
                                'designation'   => 'সহকারী প্রধান শিক্ষক',
                                'qualification' => 'এম.এ (বাংলা), বি.এড',
                                'phone'         => '01713333444',
                                'email'         => 'arun.sen@gmail.com',
                            ],
                            [
                                'name'          => 'মোসাঃ সেলিনা খাতুন',
                                'designation'   => 'সিনিয়র শিক্ষক (বিজ্ঞান)',
                                'qualification' => 'বি.এস-সি, বি.এড',
                                'phone'         => '01713555666',
                                'email'         => 'selina.science@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'শৈলকূপা পাইলট বালিকা উচ্চ বিদ্যালয়',
                        'slug'        => 'shailkupa-pilot-girls-high-school',
                        'location'    => 'বালিকা বিদ্যালয় রোড, শৈলকূপা পৌরসভা',
                        'description' => '<p>উপজেলার নারী শিক্ষার অন্যতম ভিত্তিপ্রস্তর <strong>শৈলকূপা পাইলট বালিকা উচ্চ বিদ্যালয়</strong>। মেয়েদের খেলাধুলা ও সহশিক্ষা কার্যক্রমে জেলা পর্যায়ে বিদ্যালয়টি সুনামের অধিকারী।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোছাঃ রোকেয়া বেগম',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'এম.এ, বি.এড',
                                'phone'         => '01714111222',
                                'email'         => 'rokeya.girls@gmail.com',
                            ],
                            [
                                'name'          => 'মোঃ শফিকুল ইসলাম',
                                'designation'   => 'সহকারী শিক্ষক (গণিত)',
                                'qualification' => 'বি.এস-সি (সম্মান)',
                                'phone'         => '01714333444',
                                'email'         => 'shafiq.math@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'কাতলাগাড়ী মাধ্যমিক বিদ্যালয়',
                        'slug'        => 'katlagari-secondary-school',
                        'location'    => 'কাতলাগাড়ী বাজার, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>কাতলাগাড়ী অঞ্চলের অন্যতম সেরা বিদ্যাপীঠ। বিশাল সবুজ প্রাঙ্গণ ও সুশৃঙ্খল পাঠদানের জন্য এটি সুপরিচিত।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ আনোয়ারুল কবির',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'এম.এ (ইংরেজি), বি.এড',
                                'phone'         => '01715111222',
                                'email'         => 'anwar.katlagari@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'কাঁচেরকোল বহুমুখী মাধ্যমিক বিদ্যালয়',
                        'slug'        => 'kancherkol-multilateral-secondary-school',
                        'location'    => 'কাঁচেরকোল, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>কাঁচেরকোল বহুমুখী মাধ্যমিক বিদ্যালয়টি ১৯৫৭ সালে প্রতিষ্ঠিত হয়ে এলাকার শিক্ষা বিকাশে নিরলস সেবা প্রদান করে আসছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ শওকত আলী',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'বি.এস-সি, বি.এড',
                                'phone'         => '01716111222',
                                'email'         => 'shawkat.kmhs@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'আবাইপুর রামসুন্দর মাধ্যমিক বিদ্যালয়',
                        'slug'        => 'abaipur-ramsundar-secondary-school',
                        'location'    => 'আবাইপুর বাজার, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>ঐতিহ্যবাহী আবাইপুর অঞ্চলের প্রাচীনতম শিক্ষা প্রতিষ্ঠান। স্বাধীনতা পূর্ব সময় থেকে শিক্ষার আলোকবর্তিকা বহন করে চলছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'বিপ্রদাস মিত্র',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'এম.এ (ইতিহাস), বি.এড',
                                'phone'         => '01717111222',
                                'email'         => 'biprodas.abaipur@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'সারুটিয়া মাধ্যমিক বিদ্যালয়',
                        'slug'        => 'sarutia-secondary-school',
                        'location'    => 'সারুটিয়া ইউনিয়ন পরিষদ সংলগ্ন, শৈলকূপা',
                        'description' => '<p>সারুটিয়া ইউনিয়নের মধ্যমণি এই বিদ্যালয়টি আধুনিক শিক্ষার সমন্বয়ে প্রতিবছর শতভাগ পাসের গৌরব ধরে রেখেছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ মোজাম্মেল হক',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'এম.এস-সি, বি.এড',
                                'phone'         => '01718111222',
                                'email'         => 'mozammel.sarutia@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'বেনীপুর মাধ্যমিক বিদ্যালয়',
                        'slug'        => 'benipur-secondary-school',
                        'location'    => 'বেনীপুর, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>বেনীপুর মাধ্যমিক বিদ্যালয়ে নিয়মিত পাঠদানের পাশাপাশি সহশিক্ষা ও খেলাধুলায় শিক্ষার্থীরা অগ্রণী অবদান রাখছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ খলিলুর রহমান',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'বি.এ, বি.এড',
                                'phone'         => '01719111222',
                                'email'         => 'khalil.benipur@gmail.com',
                            ],
                        ],
                    ],
                ],
            ],

            // ==============================================================
            // ৪. প্রাথমিক বিদ্যালয় (Primary School)
            // ==============================================================
            [
                'category' => [
                    'name'   => 'প্রাথমিক বিদ্যালয়',
                    'slug'   => 'primary-school',
                    'status' => true,
                ],
                'institutions' => [
                    [
                        'name'        => 'শৈলকূপা মডেল সরকারি প্রাথমিক বিদ্যালয়',
                        'slug'        => 'shailkupa-model-government-primary-school',
                        'location'    => 'পৌরসভা চত্বর, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>উপজেলার প্রধান ও মডেল প্রাথমিক বিদ্যালয়। শিশুবান্ধব শ্রেণিকক্ষ, মাল্টিমিডিয়া ক্লাস ও ক্রীড়া সামগ্রী সমৃদ্ধ একটি আধুনিক বিদ্যালয়।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোছাঃ আফরোজা পারভীন',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'এম.এ, সি-ইন-এড',
                                'phone'         => '01723111222',
                                'email'         => 'afroza.modelgps@gmail.com',
                            ],
                            [
                                'name'          => 'মোঃ কামাল হোসেন',
                                'designation'   => 'সহকারী শিক্ষক',
                                'qualification' => 'বি.এ (সম্মান), ডিপ-ইন-এড',
                                'phone'         => '01723333444',
                                'email'         => 'kamal.gps@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'কবিরপুর সরকারি প্রাথমিক বিদ্যালয়',
                        'slug'        => 'kabirpur-government-primary-school',
                        'location'    => 'কবিরপুর, শৈলকূপা পৌরসভা, ঝিনাইদহ',
                        'description' => '<p>কবিরপুর মহল্লার প্রাণকেন্দ্রে প্রতিষ্ঠিত এই বিদ্যালয়টি প্রাথমিক শিক্ষার ভিত্তি গঠনে অসামান্য অবদান রেখে আসছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ নজরুল ইসলাম',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'বি.এস-সি, বি.এড',
                                'phone'         => '01724111222',
                                'email'         => 'nazrul.kabirpur@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'বাখরবা সরকারি প্রাথমিক বিদ্যালয়',
                        'slug'        => 'bakharba-government-primary-school',
                        'location'    => 'বাখরবা গ্রাম, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>গ্রামীণ শিশুদের আনন্দঘন পরিবেশে প্রাথমিক শিক্ষা প্রদানকারী একটি আদর্শ সরকারি বিদ্যালয়।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোছাঃ মমতাজ বেগম',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'বি.এ, সি-ইন-এড',
                                'phone'         => '01725111222',
                                'email'         => 'momtaz.bakharba@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'ভাটই সরকারি প্রাথমিক বিদ্যালয়',
                        'slug'        => 'bhatoi-government-primary-school',
                        'location'    => 'ভাটই বাজার, দুধসর ইউনিয়ন, শৈলকূপা',
                        'description' => '<p>ভাটই বাজারের সন্নিকটে অবস্থিত এ বিদ্যালয়টি দীর্ঘকাল ধরে স্থানীয় শিশুদের সুশিক্ষিত করে গড়ে তুলছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ আলমগীর হোসেন',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'এম.এস-সি, ডিপ-ইন-এড',
                                'phone'         => '01726111222',
                                'email'         => 'alamgir.bhatoi@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'কাতলাগাড়ী সরকারি প্রাথমিক বিদ্যালয়',
                        'slug'        => 'katlagari-government-primary-school',
                        'location'    => 'কাতলাগাড়ী, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>কাতলাগাড়ী এলাকার শিশুদের বাধ্যতামূলক প্রাথমিক শিক্ষা ও মানসিক বিকাশে নিবেদিত বিদ্যালয়।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ আব্দুর রশিদ',
                                'designation'   => 'প্রধান শিক্ষক',
                                'qualification' => 'বি.এ, সি-ইন-এড',
                                'phone'         => '01727111222',
                                'email'         => 'rashid.katla@gmail.com',
                            ],
                        ],
                    ],
                ],
            ],

            // ==============================================================
            // ৫. কিন্ডারগার্টেন (Kindergarten)
            // ==============================================================
            [
                'category' => [
                    'name'   => 'কিন্ডারগার্টেন',
                    'slug'   => 'kindergarten',
                    'status' => true,
                ],
                'institutions' => [
                    [
                        'name'        => 'শৈলকূপা ল্যাবরেটরি কিন্ডারগার্টেন',
                        'slug'        => 'shailkupa-laboratory-kindergarten',
                        'location'    => 'কলেজ পাড়া, শৈলকূপা পৌরসভা, ঝিনাইদহ',
                        'description' => '<p>শিশুদের আনন্দঘন পরিবেশে ইংরেজি ও বাংলা মাধ্যমে আধুনিক শিক্ষা প্রদানের জন্য শৈলকূপা ল্যাবরেটরি কিন্ডারগার্টেন সুপরিচিত।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মাকসুদা আক্তার ইতি',
                                'designation'   => 'অধ্যক্ষা / প্রধান শিক্ষক',
                                'qualification' => 'এম.এ (ইংরেজি), বি.এড',
                                'phone'         => '01731111222',
                                'email'         => 'lab.kindergarten@gmail.com',
                            ],
                            [
                                'name'          => 'ফারজানা আহমেদ',
                                'designation'   => 'সহকারী শিক্ষক (শিশু শ্রেণি)',
                                'qualification' => 'বি.এ (অনার্স)',
                                'phone'         => '01731333444',
                                'email'         => 'farzana.kg@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'সানশাইন কিন্ডারগার্টেন শৈলকূপা',
                        'slug'        => 'sunshine-kindergarten-shailkupa',
                        'location'    => 'হাসপাতাল রোড, শৈলকূপা পৌরসভা',
                        'description' => '<p>আধুনিক মনস্তাত্ত্বিক পদ্ধতিতে শিশুদের মেধা ও মনন বিকাশে বিশেষ যত্নশীল একটি ব্যক্তিমালিকানাধীন প্রতিষ্ঠান।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ মাহমুদুল হাসান',
                                'designation'   => 'পরিচালক ও প্রধান শিক্ষক',
                                'qualification' => 'এম.বি.এ, বি.এড',
                                'phone'         => '01732111222',
                                'email'         => 'sunshine.shailkupa@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'কিশলয় বিদ্যা নিকেতন',
                        'slug'        => 'kisholoy-bidya-niketan-shailkupa',
                        'location'    => 'আদালত পাড়া, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>শিশুদের নৈতিকতা ও প্রাথমিক শিখন দক্ষতার মজবুত ভিত গড়ে তুলতে কিশলয় বিদ্যা নিকেতন দীর্ঘদিন সুনামের সাথে পরিচালিত হচ্ছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'সুরাইয়া ইয়াসমিন',
                                'designation'   => 'প্রধান শিক্ষিকা',
                                'qualification' => 'এম.এ (মনোবিজ্ঞান)',
                                'phone'         => '01733111222',
                                'email'         => 'kisholoy.school@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'চাঁদের হাসি প্রি-ক্যাডেট স্কুল',
                        'slug'        => 'chander-hasi-pre-cadet-school',
                        'location'    => 'কবিরপুর মোড়, শৈলকূপা',
                        'description' => '<p>ক্যাডেট স্কুল ভর্তি পরীক্ষার প্রস্তুতি ও ইংরেজি কথোপকথনে দক্ষতা অর্জনের লক্ষ্যে প্রি-ক্যাডেট পাঠদান করা হয়।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'ক্যাপ্টেন (অবঃ) মোঃ শরিফুল ইসলাম',
                                'designation'   => 'অধ্যক্ষ',
                                'qualification' => 'বি.এসসি (সম্মান)',
                                'phone'         => '01734111222',
                                'email'         => 'chanderhasi.cadet@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'শৈলকূপা শাহীন ক্যাডেট একাডেমি',
                        'slug'        => 'shailkupa-shaheen-cadet-academy',
                        'location'    => 'বাজার রোড, শৈলকূপা পৌরসভা',
                        'description' => '<p>সুশৃঙ্খল নিয়মানুবর্তিতা ও আধুনিক শিক্ষার সমন্বয়ে শিশুদের ভবিষ্যত নেতৃত্ব গড়ে তোলার লক্ষ্যে পরিচালিত একাডেমি।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মোঃ সাজ্জাদ হোসেন',
                                'designation'   => 'পরিচালক',
                                'qualification' => 'এম.কম, বি.এড',
                                'phone'         => '01735111222',
                                'email'         => 'shaheen.shailkupa@gmail.com',
                            ],
                        ],
                    ],
                ],
            ],

            // ==============================================================
            // ৬. মাদ্রাসা (Madrasa)
            // ==============================================================
            [
                'category' => [
                    'name'   => 'মাদ্রাসা',
                    'slug'   => 'madrasa',
                    'status' => true,
                ],
                'institutions' => [
                    [
                        'name'        => 'শৈলকূপা ফাজিল (ডিগ্রি) মাদ্রাসা',
                        'slug'        => 'shailkupa-fazil-degree-madrasa',
                        'location'    => 'মাদ্রাসা রোড, শৈলকূপা পৌরসভা, ঝিনাইদহ',
                        'description' => '<p><strong>শৈলকূপা ফাজিল (ডিগ্রি) মাদ্রাসা</strong> উপজেলার প্রাচীনতম ও প্রধানতম ইসলামি বিদ্যাপীঠ। ইসলামি আরবি বিশ্ববিদ্যালয় ও বাংলাদেশ মাদ্রাসা শিক্ষা বোর্ডের অধিভুক্ত এই মাদ্রাসায় দাখিল, আলিম ও ফাজিল (স্নাতক) ডিগ্রি প্রদান করা হয়।</p><p>কুরআন-সুন্নাহর সঠিক শিক্ষাদানের পাশাপাশি সাধারণ শিক্ষা ও কম্পিউটার প্রশিক্ষণ সফলতার সাথে পরিচালিত হয়।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?w=1200&q=80',
                            'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মাওলানা মোঃ আব্দুল মালেক',
                                'designation'   => 'অধ্যক্ষ',
                                'qualification' => 'কামিল (হাদিস ও ফিকহ), এম.এ',
                                'phone'         => '01741111222',
                                'email'         => 'principal.sfm@gmail.com',
                            ],
                            [
                                'name'          => 'মাওলানা মোঃ খলিলুর রহমান',
                                'designation'   => 'উপাধ্যক্ষ',
                                'qualification' => 'কামিল (তাফসির)',
                                'phone'         => '01741333444',
                                'email'         => 'khalil.sfm@gmail.com',
                            ],
                            [
                                'name'          => 'মুফতি আব্দুর রাজ্জাক',
                                'designation'   => 'প্রধান মুহাদ্দিস',
                                'qualification' => 'দাওরায়ে হাদিস, কামিল',
                                'phone'         => '01741555666',
                                'email'         => 'muhadis.sfm@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'কাতলাগাড়ী আলিম মাদ্রাসা',
                        'slug'        => 'katlagari-alim-madrasa',
                        'location'    => 'কাতলাগাড়ী বাজার, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>কাতলাগাড়ী অঞ্চলের অন্যতম শীর্ষ আলিম মাদ্রাসা। সুপরিসর ক্যাম্পাস ও দক্ষ শিক্ষক মণ্ডলী দ্বারা পাঠদান পরিচালিত হয়।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মাওলানা মোঃ ইসমাইল হোসেন',
                                'designation'   => 'অধ্যক্ষ',
                                'qualification' => 'কামিল, এম.এ',
                                'phone'         => '01742111222',
                                'email'         => 'ismail.katla@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'কাঁচেরকোল ইসলামিয়া দাখিল মাদ্রাসা',
                        'slug'        => 'kancherkol-islamia-dakhil-madrasa',
                        'location'    => 'কাঁচেরকোল, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>কাঁচেরকোল ইউনিয়নের ধর্মপ্রাণ জনসাধারণের সহযোগিতায় প্রতিষ্ঠিত ইসলামি দ্বীনি শিক্ষা প্রতিষ্ঠান।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মাওলানা নূর মোহাম্মদ',
                                'designation'   => 'সুপারিনটেনডেন্ট',
                                'qualification' => 'কামিল (ফিকহ), বি.এড',
                                'phone'         => '01743111222',
                                'email'         => 'super.kidm@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'ভাটই দারুল উলুম দাখিল মাদ্রাসা',
                        'slug'        => 'bhatoi-darul-ulum-dakhil-madrasa',
                        'location'    => 'ভাটই বাজার সংলগ্ন, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>হিফজুল কুরআন বিভাগসহ সাধারণ মাদ্রাসা শিক্ষার চমৎকার সমন্বয় রয়েছে এই প্রতিষ্ঠানে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'হাফেজ মাওলানা মোঃ জাকারিয়া',
                                'designation'   => 'সুপারিনটেনডেন্ট',
                                'qualification' => 'কামিল (হাদিস), হাফেজে কুরআন',
                                'phone'         => '01744111222',
                                'email'         => 'zakaria.bhatoi@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'সারুটিয়া ইসলামিয়া দাখিল মাদ্রাসা',
                        'slug'        => 'sarutia-islamia-dakhil-madrasa',
                        'location'    => 'সারুটিয়া, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>সারুটিয়া অঞ্চলের শিক্ষার্থীদের দ্বীনি শিক্ষা ও নৈতিকতার আলো ছড়িয়ে দিচ্ছে এই দাখিল মাদ্রাসাটি।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মাওলানা মোঃ মিজানুর রহমান',
                                'designation'   => 'সুপারিনটেনডেন্ট',
                                'qualification' => 'কামিল, এম.এ',
                                'phone'         => '01745111222',
                                'email'         => 'mizan.sarutia@gmail.com',
                            ],
                        ],
                    ],
                    [
                        'name'        => 'দুধসর আলিম মাদ্রাসা',
                        'slug'        => 'dudhsar-alim-madrasa',
                        'location'    => 'দুধসর ইউনিয়ন, শৈলকূপা, ঝিনাইদহ',
                        'description' => '<p>দুধসর আলিম মাদ্রাসা ঐতিহ্যবাহী একটি প্রতিষ্ঠান যা দাখিল ও আলিম শ্রেণিতে ধারাবাহিক ভালো ফলাফল অর্জন করে আসছে।</p>',
                        'images'      => [
                            'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?w=1200&q=80',
                        ],
                        'members'     => [
                            [
                                'name'          => 'মাওলানা মোঃ ফজলুর রহমান',
                                'designation'   => 'অধ্যক্ষ',
                                'qualification' => 'কামিল (হাদিস)',
                                'phone'         => '01746111222',
                                'email'         => 'fazlur.dudhsar@gmail.com',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($data as $catData) {
            $category = InstitutionCategory::updateOrCreate(
                ['slug' => $catData['category']['slug']],
                [
                    'name'   => $catData['category']['name'],
                    'status' => $catData['category']['status'],
                ]
            );

            foreach ($catData['institutions'] as $instData) {
                $institution = Institution::updateOrCreate(
                    ['slug' => $instData['slug']],
                    [
                        'institution_category_id' => $category->id,
                        'name'                    => $instData['name'],
                        'location'                => $instData['location'],
                        'description'             => $instData['description'],
                        'status'                  => true,
                    ]
                );

                // Images
                if (!empty($instData['images'])) {
                    // Remove existing seeder images for clean rerun
                    $institution->images()->delete();
                    foreach ($instData['images'] as $order => $imageUrl) {
                        InstitutionImage::create([
                            'institution_id' => $institution->id,
                            'image_path'     => $imageUrl,
                            'order'          => $order + 1,
                        ]);
                    }
                }

                // Members
                if (!empty($instData['members'])) {
                    $institution->members()->delete();
                    foreach ($instData['members'] as $mOrder => $m) {
                        InstitutionMember::create([
                            'institution_id' => $institution->id,
                            'name'           => $m['name'],
                            'designation'    => $m['designation'],
                            'qualification'  => $m['qualification'] ?? null,
                            'phone'          => $m['phone'] ?? null,
                            'email'          => $m['email'] ?? null,
                            'photo'          => null, // Will fallback to nice avatar via getPhotoUrlAttribute
                            'order'          => $mOrder + 1,
                        ]);
                    }
                }
            }
        }
    }
}

