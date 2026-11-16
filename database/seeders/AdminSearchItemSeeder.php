<?php

namespace Database\Seeders;

use App\Models\AdminSearchItem;
use Illuminate\Database\Seeder;

class AdminSearchItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // Dashboard
            [
                'title_bn'   => 'ড্যাশবোর্ড ওভারভিউ',
                'title_en'   => 'Dashboard Overview',
                'group_name' => 'ওভারভিউ',
                'keywords'   => 'ড্যাশবোর্ড, dashboard, home, overview, হোম, মূল পাতা, পরিসংখ্যান, analytics',
                'route_name' => 'admin.dashboard',
                'icon'       => 'ri-dashboard-line',
                'badge'      => 'মূল',
                'order'      => 1,
            ],

            // Notices
            [
                'title_bn'   => 'সকল নোটিশ ও বিজ্ঞপ্তি তালিকা',
                'title_en'   => 'Notice List & Edit',
                'group_name' => 'নোটিশ ও বিজ্ঞপ্তি',
                'keywords'   => 'নোটিশ, notice, notish, বিজ্ঞপ্তি, circular, ঘোষণা, নোটিশ এডিট, নোটিশ লিস্ট, সম্পাদনা, ফাইল ডাউনলোড',
                'route_name' => 'admin.notices.index',
                'icon'       => 'ri-notification-badge-line',
                'badge'      => 'তালিকা',
                'order'      => 10,
            ],
            [
                'title_bn'   => 'নতুন নোটিশ প্রকাশ করুন',
                'title_en'   => 'Add / Create New Notice',
                'group_name' => 'নোটিশ ও বিজ্ঞপ্তি',
                'keywords'   => 'নতুন নোটিশ, add notice, create notice, new notice, নোটিশ যোগ, নোটিশ তৈরি, বিজ্ঞপ্তি প্রকাশ, upload notice',
                'route_name' => 'admin.notices.create',
                'icon'       => 'ri-file-add-line',
                'badge'      => 'নতুন',
                'order'      => 11,
            ],

            // Volunteers
            [
                'title_bn'   => 'স্বেচ্ছাসেবী কর্মী তালিকা ও ব্যবস্থাপনা',
                'title_en'   => 'Volunteer List & Management',
                'group_name' => 'স্বেচ্ছাসেবী কর্মী',
                'keywords'   => 'স্বেচ্ছাসেবী, volunteer, কর্মী, সেবক, volunteer list, volunteer management, অনুমোদন, সক্রিয়, নিষ্ক্রিয়',
                'route_name' => 'admin.volunteers.index',
                'icon'       => 'ri-user-heart-line',
                'badge'      => 'ম্যানেজমেন্ট',
                'order'      => 20,
            ],
            [
                'title_bn'   => 'নতুন স্বেচ্ছাসেবী কর্মী নিয়োগ (ম্যানুয়াল)',
                'title_en'   => 'Add / Recruit Volunteer',
                'group_name' => 'স্বেচ্ছাসেবী কর্মী',
                'keywords'   => 'নতুন স্বেচ্ছাসেবী, add volunteer, volunteer recruit, নতুন কর্মী, কর্মী নিয়োগ, ম্যানুয়াল এন্ট্রি',
                'route_name' => 'admin.volunteers.create',
                'icon'       => 'ri-user-add-line',
                'badge'      => 'নিয়োগ',
                'order'      => 21,
            ],
            [
                'title_bn'   => 'স্বেচ্ছাসেবী ডাটা এক্সপোর্ট (CSV/Excel)',
                'title_en'   => 'Export Volunteers List',
                'group_name' => 'স্বেচ্ছাসেবী কর্মী',
                'keywords'   => 'স্বেচ্ছাসেবী এক্সপোর্ট, volunteer export, csv download, excel download, ডাটা ডাউনলোড',
                'route_name' => 'admin.volunteers.export',
                'icon'       => 'ri-file-download-line',
                'badge'      => 'এক্সপোর্ট',
                'order'      => 22,
            ],

            // Members
            [
                'title_bn'   => 'সদস্য তালিকা ও ব্যবস্থাপনা',
                'title_en'   => 'Member List & Management',
                'group_name' => 'সদস্য ব্যবস্থাপনা',
                'keywords'   => 'সদস্য, member, সদস্য তালিকা, member list, general member, সাধারণ সদস্য, সদস্যপদ, অনুমোদন, সক্রিয়',
                'route_name' => 'admin.members.index',
                'icon'       => 'ri-vip-crown-line',
                'badge'      => 'ম্যানেজমেন্ট',
                'order'      => 30,
            ],
            [
                'title_bn'   => 'নতুন সদস্য নিয়োগ (ম্যানুয়াল এন্ট্রি)',
                'title_en'   => 'Add / Recruit Member',
                'group_name' => 'সদস্য ব্যবস্থাপনা',
                'keywords'   => 'নতুন সদস্য, add member, member recruit, সদস্য নিয়োগ, সদস্য ফরম, নতুন সদস্য এন্ট্রি',
                'route_name' => 'admin.members.create',
                'icon'       => 'ri-user-add-line',
                'badge'      => 'নিয়োগ',
                'order'      => 31,
            ],
            [
                'title_bn'   => 'সদস্য ডাটা এক্সপোর্ট (CSV/Excel)',
                'title_en'   => 'Export Members List',
                'group_name' => 'সদস্য ব্যবস্থাপনা',
                'keywords'   => 'সদস্য এক্সপোর্ট, member export, csv download, সদস্য ডাউনলোড, এক্সেল',
                'route_name' => 'admin.members.export',
                'icon'       => 'ri-file-download-line',
                'badge'      => 'এক্সপোর্ট',
                'order'      => 32,
            ],

            // Donations
            [
                'title_bn'   => 'অনুদান সংগ্রহ ও হিসাব তালিকা',
                'title_en'   => 'Donations List & Transactions',
                'group_name' => 'অনুদান সংগ্রহ',
                'keywords'   => 'অনুদান, donation, fund, টাকা, অনুদান তালিকা, donation list, trx, bKash, বিকাশ, নগদ, nagad, ট্রানজেকশন, হিসাব',
                'route_name' => 'admin.donations.index',
                'icon'       => 'ri-hand-heart-line',
                'badge'      => 'হিসাব',
                'order'      => 40,
            ],
            [
                'title_bn'   => 'নতুন ম্যানুয়াল / ক্যাশ অনুদান এন্ট্রি',
                'title_en'   => 'Add Manual / Offline Donation',
                'group_name' => 'অনুদান সংগ্রহ',
                'keywords'   => 'নতুন অনুদান, add donation, manual donation, অফলাইন অনুদান, ক্যাশ অনুদান, অনুদান এন্ট্রি, রসিদ',
                'route_name' => 'admin.donations.create',
                'icon'       => 'ri-add-circle-line',
                'badge'      => 'এন্ট্রি',
                'order'      => 41,
            ],
            [
                'title_bn'   => 'অনুদান হিসাব এক্সপোর্ট (CSV)',
                'title_en'   => 'Export Donations Report',
                'group_name' => 'অনুদান সংগ্রহ',
                'keywords'   => 'অনুদান এক্সপোর্ট, donation export, csv download, অনুদান রিপোর্ট, স্টেটমেন্ট',
                'route_name' => 'admin.donations.export',
                'icon'       => 'ri-file-excel-2-line',
                'badge'      => 'রিপোর্ট',
                'order'      => 42,
            ],
            [
                'title_bn'   => 'অনুদান ব্যানার ও পেমেন্ট সেটিংস',
                'title_en'   => 'Donation Settings & Gateway',
                'group_name' => 'অনুদান সংগ্রহ',
                'keywords'   => 'অনুদান সেটিংস, donation settings, গেটওয়ে, dgepay, ডিজি পে, একাউন্ট নম্বর, অনুদান ব্যানার',
                'route_name' => 'admin.customization.donation',
                'icon'       => 'ri-bank-card-line',
                'badge'      => 'সেটিংস',
                'order'      => 43,
            ],

            // Committees
            [
                'title_bn'   => 'কমিটি ব্যবস্থাপনা (কার্যনির্বাহী ও অন্যান্য)',
                'title_en'   => 'Committees Management',
                'group_name' => 'কমিটি ব্যবস্থাপনা',
                'keywords'   => 'কমিটি, committee, কার্যনির্বাহী কমিটি, উপদেষ্টা কমিটি, committee list, কমিটি তালিকা',
                'route_name' => 'admin.committees.index',
                'icon'       => 'ri-team-line',
                'badge'      => 'কমিটি',
                'order'      => 50,
            ],
            [
                'title_bn'   => 'কমিটির সদস্য তালিকা ও পদবী',
                'title_en'   => 'Committee Members & Designations',
                'group_name' => 'কমিটি ব্যবস্থাপনা',
                'keywords'   => 'কমিটি সদস্য, committee members, পদবী, মেম্বার, সভাপতি, সম্পাদক, সদস্য তালিকা',
                'route_name' => 'admin.committee-members.index',
                'icon'       => 'ri-user-settings-line',
                'badge'      => 'সদস্য',
                'order'      => 51,
            ],

            // Events
            [
                'title_bn'   => 'সকল কার্যক্রম ও ইভেন্ট তালিকা',
                'title_en'   => 'Events & Activities List',
                'group_name' => 'কার্যক্রম ও ইভেন্ট',
                'keywords'   => 'ইভেন্ট, event, কার্যক্রম, কর্মসূচি, অনুষ্ঠান, event list, ইভেন্ট এডিট',
                'route_name' => 'admin.events.index',
                'icon'       => 'ri-calendar-event-line',
                'badge'      => 'তালিকা',
                'order'      => 60,
            ],
            [
                'title_bn'   => 'নতুন কার্যক্রম বা ইভেন্ট যোগ করুন',
                'title_en'   => 'Create New Event',
                'group_name' => 'কার্যক্রম ও ইভেন্ট',
                'keywords'   => 'নতুন ইভেন্ট, add event, create event, নতুন কার্যক্রম, নতুন কর্মসূচি, অনুষ্ঠান যোগ',
                'route_name' => 'admin.events.create',
                'icon'       => 'ri-calendar-check-line',
                'badge'      => 'নতুন',
                'order'      => 61,
            ],

            // Projects
            [
                'title_bn'   => 'উন্নয়ন প্রকল্পসমূহের তালিকা',
                'title_en'   => 'Development Projects List',
                'group_name' => 'উন্নয়ন প্রকল্প',
                'keywords'   => 'প্রকল্প, project, উন্নয়ন প্রকল্প, প্রজেক্ট তালিকা, project list, চলমান প্রকল্প, সম্পন্ন প্রকল্প',
                'route_name' => 'admin.projects.index',
                'icon'       => 'ri-building-line',
                'badge'      => 'তালিকা',
                'order'      => 70,
            ],
            [
                'title_bn'   => 'নতুন উন্নয়ন প্রকল্প যুক্ত করুন',
                'title_en'   => 'Add New Project',
                'group_name' => 'উন্নয়ন প্রকল্প',
                'keywords'   => 'নতুন প্রকল্প, add project, create project, নতুন প্রজেক্ট, প্রকল্প এন্ট্রি',
                'route_name' => 'admin.projects.create',
                'icon'       => 'ri-folder-add-line',
                'badge'      => 'নতুন',
                'order'      => 71,
            ],

            // Blog Posts
            [
                'title_bn'   => 'সকল ব্লগ ও আপডেট তালিকা',
                'title_en'   => 'Blog Posts & Updates',
                'group_name' => 'ব্লগ ও আপডেট',
                'keywords'   => 'ব্লগ, post, blog, আর্টিকেল, নিউজ, সংবাদ, খবর, post list, ব্লগ এডিট, পোস্ট তালিকা',
                'route_name' => 'admin.posts.index',
                'icon'       => 'ri-article-line',
                'badge'      => 'পোস্ট',
                'order'      => 80,
            ],
            [
                'title_bn'   => 'নতুন ব্লগ পোস্ট লিখুন / প্রকাশ করুন',
                'title_en'   => 'Create New Blog Post',
                'group_name' => 'ব্লগ ও আপডেট',
                'keywords'   => 'নতুন পোস্ট, add post, create blog, ব্লগ লিখুন, নতুন সংবাদ, নতুন খবর, আর্টিকেল লিখুন',
                'route_name' => 'admin.posts.create',
                'icon'       => 'ri-edit-2-line',
                'badge'      => 'নতুন',
                'order'      => 81,
            ],
            [
                'title_bn'   => 'ব্লগ ক্যাটাগরি ব্যবস্থাপনা',
                'title_en'   => 'Blog Categories',
                'group_name' => 'ব্লগ ও আপডেট',
                'keywords'   => 'ব্লগ ক্যাটাগরি, category, categories, বিভাগ, ক্যাটাগরি যোগ, ক্যাটাগরি এডিট',
                'route_name' => 'admin.categories.index',
                'icon'       => 'ri-price-tag-3-line',
                'badge'      => 'বিভাগ',
                'order'      => 82,
            ],

            // Gallery
            [
                'title_bn'   => 'গ্যালারি ফটো ও ভিডিও অ্যালবাম',
                'title_en'   => 'Gallery Media & Albums',
                'group_name' => 'গ্যালারি',
                'keywords'   => 'গ্যালারি, gallery, ছবি, ভিডিও, photo, video, অ্যালবাম, গ্যালারি তালিকা, ছবি মুছুন',
                'route_name' => 'admin.gallery.index',
                'icon'       => 'ri-image-2-line',
                'badge'      => 'মিডিয়া',
                'order'      => 90,
            ],
            [
                'title_bn'   => 'নতুন ছবি বা ভিডিও যুক্ত করুন',
                'title_en'   => 'Add Gallery Photo / Video',
                'group_name' => 'গ্যালারি',
                'keywords'   => 'নতুন ছবি, add gallery, upload photo, ছবি আপলোড, ভিডিও আপলোড, ফটো যোগ',
                'route_name' => 'admin.gallery.create',
                'icon'       => 'ri-image-add-line',
                'badge'      => 'আপলোড',
                'order'      => 91,
            ],

            // Pride
            [
                'title_bn'   => 'কৃতি সন্তান তালিকা ও প্রোফাইল',
                'title_en'   => 'Our Pride Personalities',
                'group_name' => 'কৃতি সন্তান',
                'keywords'   => 'কৃতি সন্তান, pride, বিশিষ্ট ব্যক্তি, গুণীজন, শৈলকুপার কৃতি সন্তান',
                'route_name' => 'admin.prides.index',
                'icon'       => 'ri-award-line',
                'badge'      => 'কৃতি সন্তান',
                'order'      => 100,
            ],

            // Places
            [
                'title_bn'   => 'দর্শনীয় স্থানসমূহ',
                'title_en'   => 'Tourist & Historic Places',
                'group_name' => 'দর্শনীয় স্থান',
                'keywords'   => 'দর্শনীয় স্থান, places, পর্যটন, ঐতিহাসিক স্থান, শৈলকুপা স্থান, ভ্রমণ',
                'route_name' => 'admin.places.index',
                'icon'       => 'ri-map-pin-2-line',
                'badge'      => 'স্থান',
                'order'      => 110,
            ],

            // Institutions
            [
                'title_bn'   => 'সকল প্রতিষ্ঠান সমূহ (স্কুল, কলেজ, মাদ্রাসা)',
                'title_en'   => 'Institutions Management',
                'group_name' => 'প্রতিষ্ঠান সমূহ',
                'keywords'   => 'প্রতিষ্ঠান, institution, স্কুল, কলেজ, মাদ্রাসা, হাসপাতাল, ব্যাংক, শিক্ষা প্রতিষ্ঠান',
                'route_name' => 'admin.institutions.index',
                'icon'       => 'ri-government-line',
                'badge'      => 'প্রতিষ্ঠান',
                'order'      => 120,
            ],

            // Offices
            [
                'title_bn'   => 'সরকারি ও বেসরকারি অফিস সমূহ',
                'title_en'   => 'Offices & Organizations',
                'group_name' => 'অফিস সমূহ',
                'keywords'   => 'অফিস, office, সরকারি অফিস, থানা, উপজেলা পরিষদ, বিদ্যুৎ অফিস, হেল্পলাইন',
                'route_name' => 'admin.offices.index',
                'icon'       => 'ri-community-line',
                'badge'      => 'অফিস',
                'order'      => 130,
            ],

            // Unions
            [
                'title_bn'   => 'ইউনিয়ন পরিষদ পরিচিতি ও তথ্য',
                'title_en'   => 'Union Parishads List',
                'group_name' => 'ইউনিয়ন পরিচিতি',
                'keywords'   => 'ইউনিয়ন, union, ইউনিয়ন পরিষদ, চেয়ারম্যান, মেম্বার, ১৪টি ইউনিয়ন',
                'route_name' => 'admin.unions.index',
                'icon'       => 'ri-map-2-line',
                'badge'      => 'ইউনিয়ন',
                'order'      => 140,
            ],

            // Contact Messages
            [
                'title_bn'   => 'যোগাযোগ ইনবক্স ও বার্তাসমূহ',
                'title_en'   => 'Contact Messages Inbox',
                'group_name' => 'ইনবক্স',
                'keywords'   => 'বার্তা, message, contact message, যোগাযোগ, ইনবক্স, অভিযোগ, মতামত, ইমেইল বার্তা',
                'route_name' => 'admin.contact-messages.index',
                'icon'       => 'ri-mail-unread-line',
                'badge'      => 'ইনবক্স',
                'order'      => 150,
            ],

            // Dynamic Pages
            [
                'title_bn'   => 'সকল ডায়নামিক পেজ তালিকা ও সম্পাদনা',
                'title_en'   => 'Custom Pages Management',
                'group_name' => 'পেজ ব্যবস্থাপনা',
                'keywords'   => 'পেজ, page, pages, পেজ তৈরি, পেজ এডিট, পেজ তালিকা, ডায়নামিক পেজ, নতুন পেজ',
                'route_name' => 'admin.pages.index',
                'icon'       => 'ri-pages-line',
                'badge'      => 'পেজ',
                'order'      => 155,
            ],
            [
                'title_bn'   => 'নতুন পেজ তৈরি করুন',
                'title_en'   => 'Create New Custom Page',
                'group_name' => 'পেজ ব্যবস্থাপনা',
                'keywords'   => 'নতুন পেজ, add page, create page, নতুন পাতা, পেজ তৈরি',
                'route_name' => 'admin.pages.create',
                'icon'       => 'ri-file-add-line',
                'badge'      => 'তৈরি',
                'order'      => 156,
            ],

            // Customization
            [
                'title_bn'   => 'ওয়েবসাইট লোগো ও ব্র্যান্ডিং সেটিংস',
                'title_en'   => 'Logo & Branding Customization',
                'group_name' => 'কাস্টমাইজেশন',
                'keywords'   => 'লোগো, logo, branding, সাইট নাম, টাইটেল, স্লোগান, ফেভিকন, favicon, ব্র্যান্ডিং, লোগো পরিবর্তন',
                'route_name' => 'admin.customization.branding',
                'icon'       => 'ri-paint-brush-line',
                'badge'      => 'ব্র্যান্ডিং',
                'order'      => 160,
            ],
            [
                'title_bn'   => 'হোমপেজ হিরো ব্যানার ও স্লাইডার',
                'title_en'   => 'Hero Banners & Slider',
                'group_name' => 'কাস্টমাইজেশন',
                'keywords'   => 'ব্যানার, hero banner, স্লাইডার, slider, হোম ব্যানার, ব্যানার পরিবর্তন, ছবি',
                'route_name' => 'admin.hero-banners.index',
                'icon'       => 'ri-slideshow-line',
                'badge'      => 'ব্যানার',
                'order'      => 161,
            ],
            [
                'title_bn'   => 'পরিসংখ্যান কাউন্টার সেটিংস',
                'title_en'   => 'Statistics Counters',
                'group_name' => 'কাস্টমাইজেশন',
                'keywords'   => 'পরিসংখ্যান, counter, stats, stat counter, সংখ্যা, হোমপেজ তথ্য',
                'route_name' => 'admin.stat-counters.index',
                'icon'       => 'ri-bar-chart-box-line',
                'badge'      => 'কাউন্টার',
                'order'      => 162,
            ],
            [
                'title_bn'   => 'আমাদের সম্পর্কে পরিচিতি সেটিংস',
                'title_en'   => 'About Us Content Settings',
                'group_name' => 'কাস্টমাইজেশন',
                'keywords'   => 'আমাদের সম্পর্কে, about us, পরিচিতি, লক্ষ্য, উদ্দেশ্য, বিবরণ',
                'route_name' => 'admin.customization.about',
                'icon'       => 'ri-information-line',
                'badge'      => 'পরিচিতি',
                'order'      => 163,
            ],
            [
                'title_bn'   => 'সভাপতির বাণী কাস্টমাইজেশন',
                'title_en'   => 'President Message Settings',
                'group_name' => 'কাস্টমাইজেশন',
                'keywords'   => 'সভাপতি, president, বাণী, মেসেজ, সভাপতির ছবি, বক্তব্য',
                'route_name' => 'admin.customization.president',
                'icon'       => 'ri-user-voice-line',
                'badge'      => 'বাণী',
                'order'      => 164,
            ],
            [
                'title_bn'   => 'ফুটার কন্টেন্ট ও সোশ্যাল লিংক সেটিংস',
                'title_en'   => 'Footer & Social Links Settings',
                'group_name' => 'কাস্টমাইজেশন',
                'keywords'   => 'ফুটার, footer, কপিরাইট, সোশ্যাল লিংক, ফেসবুক, ইউটিউব, লিংক',
                'route_name' => 'admin.customization.footer',
                'icon'       => 'ri-layout-bottom-line',
                'badge'      => 'ফুটার',
                'order'      => 165,
            ],
            [
                'title_bn'   => 'যোগাযোগ তথ্য সেটিংস (ঠিকানা, ফোন, ম্যাপ)',
                'title_en'   => 'Contact Info & Address Settings',
                'group_name' => 'কাস্টমাইজেশন',
                'keywords'   => 'যোগাযোগ তথ্য, contact info, ঠিকানা, ইমেইল, ফোন নম্বর, গুগল ম্যাপ',
                'route_name' => 'admin.customization.contact',
                'icon'       => 'ri-contacts-book-line',
                'badge'      => 'যোগাযোগ',
                'order'      => 166,
            ],
            [
                'title_bn'   => 'টপবার সেটিংস (জরুরি ঘোষণা ও হেল্পলাইন)',
                'title_en'   => 'Topbar Settings & Hotline',
                'group_name' => 'কাস্টমাইজেশন',
                'keywords'   => 'টপবার, topbar, হেল্পলাইন, নোটিশ স্ক্রল, ইমেইল, ফোন',
                'route_name' => 'admin.customization.topbar',
                'icon'       => 'ri-layout-top-line',
                'badge'      => 'টপবার',
                'order'      => 167,
            ],
            [
                'title_bn'   => 'হেডার মেনু ও নেভিগেশন বার সেটিংস',
                'title_en'   => 'Navbar Menu Customization',
                'group_name' => 'কাস্টমাইজেশন',
                'keywords'   => 'মেনু, navbar, নেভবার, হেডার, menu items, নেভিগেশন',
                'route_name' => 'admin.customization.navbar',
                'icon'       => 'ri-menu-line',
                'badge'      => 'মেনু',
                'order'      => 168,
            ],

            // Users & Security
            [
                'title_bn'   => 'অ্যাডমিন ও ব্যবহারকারী তালিকা',
                'title_en'   => 'Users & Admins List',
                'group_name' => 'নিরাপত্তা ও ইউজার',
                'keywords'   => 'ব্যবহারকারী, user, অ্যাডমিন ইউজার, ইউজার তালিকা, একাউন্ট, এডমিন',
                'route_name' => 'admin.users.index',
                'icon'       => 'ri-user-line',
                'badge'      => 'ইউজার',
                'order'      => 170,
            ],
            [
                'title_bn'   => 'ভূমিকা ও পারমিশন ব্যবস্থাপনা (Roles & Permissions)',
                'title_en'   => 'Roles & Permissions',
                'group_name' => 'নিরাপত্তা ও ইউজার',
                'keywords'   => 'রোল, role, permission, পারমিশন, অনুমতি, ক্ষমতা, ভূমিকা, অ্যাক্সেস',
                'route_name' => 'admin.roles.index',
                'icon'       => 'ri-shield-keyhole-line',
                'badge'      => 'পারমিশন',
                'order'      => 171,
            ],
            [
                'title_bn'   => 'ইমেইল সার্ভার (SMTP Mail) কনফিগারেশন',
                'title_en'   => 'Email & SMTP Mail Server Settings',
                'group_name' => 'সিস্টেম সেটিংস',
                'keywords'   => 'ইমেইল সেটিংস, mail settings, smtp, মেইল সার্ভার, জিমেইল, পোর্ট, পাসওয়ার্ড, টেস্ট মেইল',
                'route_name' => 'admin.settings.mail',
                'icon'       => 'ri-mail-settings-line',
                'badge'      => 'সার্ভার',
                'order'      => 180,
            ],
            [
                'title_bn'   => 'আমার প্রোফাইল ও পাসওয়ার্ড পরিবর্তন',
                'title_en'   => 'My Profile & Password Settings',
                'group_name' => 'অ্যাকাউন্ট',
                'keywords'   => 'প্রোফাইল, profile, পাসওয়ার্ড, password, অ্যাকাউন্ট, ছবি পরিবর্তন, নিরাপত্তা',
                'route_name' => 'admin.profile',
                'icon'       => 'ri-account-circle-line',
                'badge'      => 'প্রোফাইল',
                'order'      => 190,
            ],
        ];

        AdminSearchItem::truncate();

        foreach ($items as $item) {
            AdminSearchItem::create($item);
        }
    }
}
