<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Granular System Permissions by Module
    |--------------------------------------------------------------------------
    |
    | Comprehensive list of all modules and their granular route/action-level
    | permissions for আগামীর শৈলকুপা administrative platform.
    |
    */
    'modules' => [
        'members' => [
            'name_bn' => 'সদস্য ব্যবস্থাপনা (Members)',
            'name_en' => 'Member Management',
            'icon'    => 'ri-user-star-line',
            'color'   => '#0b4622',
            'permissions' => [
                'members.view'   => ['title' => 'সদস্য তালিকা ও বিস্তারিত দেখুন', 'desc' => 'View member list & details'],
                'members.create' => ['title' => 'নতুন সদস্য যুক্ত করুন', 'desc' => 'Add new members manually'],
                'members.edit'   => ['title' => 'সদস্য তথ্য সম্পাদনা করুন', 'desc' => 'Edit member details and photos'],
                'members.delete' => ['title' => 'সদস্য রেকর্ড মুছে ফেলুন', 'desc' => 'Delete members from database'],
                'members.status' => ['title' => 'সদস্য অনুমোদন ও স্ট্যাটাস পরিবর্তন', 'desc' => 'Approve or toggle member status'],
                'members.export' => ['title' => 'সদস্য ডাটা এক্সপোর্ট করুন (CSV)', 'desc' => 'Export member records to CSV/Excel'],
            ],
        ],

        'volunteers' => [
            'name_bn' => 'স্বেচ্ছাসেবী কর্মী (Volunteers)',
            'name_en' => 'Volunteer Management',
            'icon'    => 'ri-hand-heart-line',
            'color'   => '#0d9488',
            'permissions' => [
                'volunteers.view'   => ['title' => 'স্বেচ্ছাসেবী তালিকা ও বিবরণ দেখুন', 'desc' => 'View volunteer list & profile'],
                'volunteers.create' => ['title' => 'নতুন স্বেচ্ছাসেবী যুক্ত করুন', 'desc' => 'Add new volunteers manually'],
                'volunteers.edit'   => ['title' => 'স্বেচ্ছাসেবী তথ্য সম্পাদনা করুন', 'desc' => 'Edit volunteer details and photos'],
                'volunteers.delete' => ['title' => 'স্বেচ্ছাসেবী রেকর্ড মুছে ফেলুন', 'desc' => 'Delete volunteer records'],
                'volunteers.status' => ['title' => 'স্বেচ্ছাসেবী অনুমোদন ও স্ট্যাটাস পরিবর্তন', 'desc' => 'Approve or toggle volunteer status'],
                'volunteers.export' => ['title' => 'স্বেচ্ছাসেবী ডাটা এক্সপোর্ট করুন (CSV)', 'desc' => 'Export volunteer records to CSV/Excel'],
            ],
        ],

        'donations' => [
            'name_bn' => 'অনুদান সংগ্রহ ও তহবিল (Donations)',
            'name_en' => 'Donation & Fund Management',
            'icon'    => 'ri-money-dollar-circle-line',
            'color'   => '#059669',
            'permissions' => [
                'donations.view'   => ['title' => 'অনুদান তালিকা ও লেনদেন দেখুন', 'desc' => 'View donation transactions and receipts'],
                'donations.create' => ['title' => 'অফলাইন / ক্যাশ অনুদান এন্ট্রি করুন', 'desc' => 'Add manual offline cash donations'],
                'donations.edit'   => ['title' => 'অনুদান রসিদ ও তথ্য সম্পাদনা', 'desc' => 'Edit donation vouchers and records'],
                'donations.delete' => ['title' => 'অনুদান রেকর্ড মুছে ফেলুন', 'desc' => 'Delete donation transactions'],
                'donations.export' => ['title' => 'অনুদান রিপোর্ট এক্সপোর্ট করুন (CSV)', 'desc' => 'Export donation statements to CSV'],
            ],
        ],

        'notices' => [
            'name_bn' => 'নোটিশ ও বিজ্ঞপ্তি (Notices)',
            'name_en' => 'Notices & Announcements',
            'icon'    => 'ri-notification-badge-line',
            'color'   => '#d97706',
            'permissions' => [
                'notices.view'   => ['title' => 'সকল নোটিশ তালিকা দেখুন', 'desc' => 'View notices and circulars'],
                'notices.create' => ['title' => 'নতুন নোটিশ প্রকাশ করুন', 'desc' => 'Publish new notices and attach files'],
                'notices.edit'   => ['title' => 'নোটিশ সম্পাদনা করুন', 'desc' => 'Edit published notice contents and dates'],
                'notices.delete' => ['title' => 'নোটিশ মুছে ফেলুন', 'desc' => 'Delete notices from the portal'],
            ],
        ],

        'events' => [
            'name_bn' => 'কর্মসূচি ও ইভেন্ট (Events)',
            'name_en' => 'Events & Programs',
            'icon'    => 'ri-calendar-event-line',
            'color'   => '#7c3aed',
            'permissions' => [
                'events.view'   => ['title' => 'ইভেন্ট তালিকা ও বিবরণ দেখুন', 'desc' => 'View events and activities schedule'],
                'events.create' => ['title' => 'নতুন ইভেন্ট যুক্ত করুন', 'desc' => 'Create new events and programs'],
                'events.edit'   => ['title' => 'ইভেন্ট সম্পাদনা করুন', 'desc' => 'Edit event schedule, location, and photos'],
                'events.delete' => ['title' => 'ইভেন্ট মুছে ফেলুন', 'desc' => 'Delete events from the system'],
            ],
        ],

        'projects' => [
            'name_bn' => 'উন্নয়ন প্রকল্পসমূহ (Projects)',
            'name_en' => 'Development Projects',
            'icon'    => 'ri-projector-line',
            'color'   => '#2563eb',
            'permissions' => [
                'projects.view'   => ['title' => 'প্রকল্প তালিকা ও অগ্রগতি দেখুন', 'desc' => 'View ongoing and completed projects'],
                'projects.create' => ['title' => 'নতুন প্রকল্প তৈরি করুন', 'desc' => 'Add new development projects'],
                'projects.edit'   => ['title' => 'প্রকল্প সম্পাদনা করুন', 'desc' => 'Edit project milestones, status and photos'],
                'projects.delete' => ['title' => 'প্রকল্প মুছে ফেলুন', 'desc' => 'Delete projects from portal'],
            ],
        ],

        'committees' => [
            'name_bn' => 'কমিটি ব্যবস্থাপনা (Committees)',
            'name_en' => 'Committees & Members',
            'icon'    => 'ri-team-line',
            'color'   => '#0b4622',
            'permissions' => [
                'committees.view'   => ['title' => 'কমিটি ও সদস্য তালিকা দেখুন', 'desc' => 'View committees and executive members'],
                'committees.create' => ['title' => 'নতুন কমিটি ও সদস্য যুক্ত করুন', 'desc' => 'Create committees and add member designations'],
                'committees.edit'   => ['title' => 'কমিটি ও সদস্য তথ্য সম্পাদনা', 'desc' => 'Edit committee designations and photos'],
                'committees.delete' => ['title' => 'কমিটি ও সদস্য মুছে ফেলুন', 'desc' => 'Delete committees and members'],
            ],
        ],

        'posts' => [
            'name_bn' => 'ব্লগ ও সংবাদ (Blog Posts)',
            'name_en' => 'Blog Posts & Updates',
            'icon'    => 'ri-article-line',
            'color'   => '#4f46e5',
            'permissions' => [
                'posts.view'   => ['title' => 'ব্লগ পোস্ট ও ক্যাটাগরি দেখুন', 'desc' => 'View blog articles and categories'],
                'posts.create' => ['title' => 'নতুন পোস্ট লিখুন ও ক্যাটাগরি তৈরি করুন', 'desc' => 'Create blog posts and categories'],
                'posts.edit'   => ['title' => 'পোস্ট ও ক্যাটাগরি সম্পাদনা করুন', 'desc' => 'Edit blog posts and categories'],
                'posts.delete' => ['title' => 'পোস্ট ও ক্যাটাগরি মুছে ফেলুন', 'desc' => 'Delete blog posts and categories'],
            ],
        ],

        'gallery' => [
            'name_bn' => 'গ্যালারি মিডিয়া (Gallery)',
            'name_en' => 'Photo & Video Gallery',
            'icon'    => 'ri-image-add-line',
            'color'   => '#0891b2',
            'permissions' => [
                'gallery.view'   => ['title' => 'গ্যালারি মিডিয়া অ্যালবাম দেখুন', 'desc' => 'View media album and items'],
                'gallery.create' => ['title' => 'ছবি বা ভিডিও আপলোড করুন', 'desc' => 'Upload photos and video links'],
                'gallery.edit'   => ['title' => 'গ্যালারি কন্টেন্ট সম্পাদনা করুন', 'desc' => 'Edit gallery titles and order'],
                'gallery.delete' => ['title' => 'গ্যালারি কন্টেন্ট মুছে ফেলুন', 'desc' => 'Delete gallery photos and videos'],
            ],
        ],

        'prides' => [
            'name_bn' => 'কৃতি সন্তান (Pride Personalities)',
            'name_en' => 'Pride of Shailkupa',
            'icon'    => 'ri-award-line',
            'color'   => '#b45309',
            'permissions' => [
                'prides.view'   => ['title' => 'কৃতি সন্তান তালিকা দেখুন', 'desc' => 'View pride personality profiles'],
                'prides.create' => ['title' => 'নতুন কৃতি সন্তান প্রোফাইল যোগ করুন', 'desc' => 'Add new distinguished personality'],
                'prides.edit'   => ['title' => 'কৃতি সন্তান প্রোফাইল সম্পাদনা করুন', 'desc' => 'Edit personality details and photos'],
                'prides.delete' => ['title' => 'কৃতি সন্তান প্রোফাইল মুছে ফেলুন', 'desc' => 'Delete personality profile'],
            ],
        ],

        'places' => [
            'name_bn' => 'দর্শনীয় স্থান (Places)',
            'name_en' => 'Historic & Tourist Places',
            'icon'    => 'ri-map-pin-2-line',
            'color'   => '#15803d',
            'permissions' => [
                'places.view'   => ['title' => 'দর্শনীয় স্থান তালিকা দেখুন', 'desc' => 'View tourist and historic places'],
                'places.create' => ['title' => 'নতুন দর্শনীয় স্থান যুক্ত করুন', 'desc' => 'Add new place details and photos'],
                'places.edit'   => ['title' => 'স্থানের তথ্য সম্পাদনা করুন', 'desc' => 'Edit place information and gallery'],
                'places.delete' => ['title' => 'স্থান মুছে ফেলুন', 'desc' => 'Delete places from portal'],
            ],
        ],

        'institutions' => [
            'name_bn' => 'প্রতিষ্ঠান সমূহ (Institutions)',
            'name_en' => 'Institutions Directory',
            'icon'    => 'ri-government-line',
            'color'   => '#1e40af',
            'permissions' => [
                'institutions.view'   => ['title' => 'প্রতিষ্ঠান তালিকা দেখুন', 'desc' => 'View schools, colleges, madrasas, hospitals'],
                'institutions.create' => ['title' => 'নতুন প্রতিষ্ঠান যুক্ত করুন', 'desc' => 'Add new institution directory entry'],
                'institutions.edit'   => ['title' => 'প্রতিষ্ঠান তথ্য সম্পাদনা করুন', 'desc' => 'Edit institution details and contacts'],
                'institutions.delete' => ['title' => 'প্রতিষ্ঠান মুছে ফেলুন', 'desc' => 'Delete institutions from directory'],
            ],
        ],

        'offices' => [
            'name_bn' => 'অফিস সমূহ (Offices)',
            'name_en' => 'Offices & Organizations',
            'icon'    => 'ri-community-line',
            'color'   => '#374151',
            'permissions' => [
                'offices.view'   => ['title' => 'অফিস তালিকা দেখুন', 'desc' => 'View govt and public offices'],
                'offices.create' => ['title' => 'নতুন অফিস যোগ করুন', 'desc' => 'Add new office and hotline contacts'],
                'offices.edit'   => ['title' => 'অফিস তথ্য সম্পাদনা করুন', 'desc' => 'Edit office details, head person and phone'],
                'offices.delete' => ['title' => 'অফিস মুছে ফেলুন', 'desc' => 'Delete office from portal'],
            ],
        ],

        'unions' => [
            'name_bn' => 'ইউনিয়ন পরিষদ (Unions)',
            'name_en' => 'Union Parishads',
            'icon'    => 'ri-map-2-line',
            'color'   => '#065f46',
            'permissions' => [
                'unions.view'   => ['title' => 'ইউনিয়ন পরিচিতি ও তালিকা দেখুন', 'desc' => 'View 14 Union Parishads information'],
                'unions.create' => ['title' => 'নতুন ইউনিয়ন তথ্য যুক্ত করুন', 'desc' => 'Add new union council information'],
                'unions.edit'   => ['title' => 'ইউনিয়ন তথ্য সম্পাদনা করুন', 'desc' => 'Edit union council profile, chairman and map'],
                'unions.delete' => ['title' => 'ইউনিয়ন তথ্য মুছে ফেলুন', 'desc' => 'Delete union council information'],
            ],
        ],

        'person_messages' => [
            'name_bn' => 'ব্যক্তিবর্গের বাণী (Person Messages)',
            'name_en' => 'Messages & Speeches',
            'icon'    => 'ri-chat-quote-line',
            'color'   => '#9333ea',
            'permissions' => [
                'person_messages.view'   => ['title' => 'বাণী তালিকা দেখুন', 'desc' => 'View messages from dignitaries & advisors'],
                'person_messages.create' => ['title' => 'নতুন বাণী যোগ করুন', 'desc' => 'Add messages from advisors / dignitaries'],
                'person_messages.edit'   => ['title' => 'বাণী সম্পাদনা করুন', 'desc' => 'Edit message content and speaker photo'],
                'person_messages.delete' => ['title' => 'বাণী মুছে ফেলুন', 'desc' => 'Delete message entries'],
            ],
        ],

        'pages' => [
            'name_bn' => 'পেজ ব্যবস্থাপনা (Custom Pages)',
            'name_en' => 'Dynamic Pages Management',
            'icon'    => 'ri-pages-line',
            'color'   => '#0284c7',
            'permissions' => [
                'pages.view'   => ['title' => 'পেজ তালিকা দেখুন', 'desc' => 'View dynamic custom pages'],
                'pages.create' => ['title' => 'নতুন পেজ তৈরি করুন', 'desc' => 'Create new dynamic custom pages with slug'],
                'pages.edit'   => ['title' => 'পেজ সম্পাদনা করুন', 'desc' => 'Edit page title, slug, content and status'],
                'pages.delete' => ['title' => 'পেজ মুছে ফেলুন', 'desc' => 'Delete custom dynamic pages'],
            ],
        ],

        'contact_messages' => [
            'name_bn' => 'যোগাযোগ ইনবক্স (Contact Messages)',
            'name_en' => 'Contact Inbox',
            'icon'    => 'ri-mail-unread-line',
            'color'   => '#c8102e',
            'permissions' => [
                'contact_messages.view'   => ['title' => 'ইনবক্স বার্তা দেখুন ও পড়ুন', 'desc' => 'View incoming inquiries and messages'],
                'contact_messages.delete' => ['title' => 'বার্তা মুছে ফেলুন', 'desc' => 'Delete messages from contact inbox'],
            ],
        ],

        'customization' => [
            'name_bn' => 'কাস্টমাইজেশন ও ব্র্যান্ডিং (Customization)',
            'name_en' => 'Website Customization & Branding',
            'icon'    => 'ri-paint-brush-line',
            'color'   => '#0b4622',
            'permissions' => [
                'customization.view'   => ['title' => 'কাস্টমাইজেশন সেটিংস দেখুন', 'desc' => 'View branding, topbar, navbar, banner, footer'],
                'customization.update' => ['title' => 'লোগো, ব্যানার, ফুটার ও কন্টেন্ট পরিবর্তন', 'desc' => 'Update branding, logos, sliders, counters'],
            ],
        ],

        'users' => [
            'name_bn' => 'ব্যবহারকারী ও রোল (Users & Security)',
            'name_en' => 'Users & Access Control',
            'icon'    => 'ri-shield-user-line',
            'color'   => '#1f2937',
            'permissions' => [
                'users.view'   => ['title' => 'ব্যবহারকারী তালিকা দেখুন', 'desc' => 'View registered users and admins'],
                'users.create' => ['title' => 'নতুন ব্যবহারকারী তৈরি করুন', 'desc' => 'Create new users and admin accounts'],
                'users.edit'   => ['title' => 'ব্যবহারকারী তথ্য ও রোল পরিবর্তন', 'desc' => 'Edit user profile and assign roles'],
                'users.delete' => ['title' => 'ব্যবহারকারী মুছে ফেলুন', 'desc' => 'Delete user accounts'],
                'roles.manage' => ['title' => 'রোল ও পারমিশন অ্যাসাইনমেন্ট পরিচালনা', 'desc' => 'Manage roles and assign granular permissions'],
            ],
        ],

        'settings' => [
            'name_bn' => 'সিস্টেম সেটিংস (System Settings)',
            'name_en' => 'System & Mail Settings',
            'icon'    => 'ri-settings-4-line',
            'color'   => '#475569',
            'permissions' => [
                'settings.mail' => ['title' => 'ইমেইল সার্ভার (SMTP) সেটিংস পরিচালনা', 'desc' => 'Configure and test SMTP mail server'],
            ],
        ],
    ],
];
