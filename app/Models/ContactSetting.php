<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_name',
        'location',
        'phone',
        'email',
        'alt_phone',
        'address',
        'map_iframe',
    ];

    /**
     * Get or create the singleton contact setting record.
     */
    public static function getSettings(): self
    {
        return self::firstOrCreate([], [
            'office_name' => 'আগামীর শৈলকুপা কেন্দ্রীয় কার্যালয়',
            'location' => 'শৈলকুপা, ঝিনাইদহ',
            'phone' => '+880 1700-123456',
            'email' => 'info@agamirshailkupa.org',
            'alt_phone' => '+880 1800-123456',
            'address' => 'শৈলকুপা পৌরসভা মোড়, শৈলকুপা, ঝিনাইদহ, বাংলাদেশ',
            'map_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58548.86811211728!2d89.21376878206899!3d23.68962635959954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fed5b3d6d061f5%3A0xc07a829f03224b7!2sShailkupa!5e0!3m2!1sen!2sbd!4v1700000000000!5m2!1sen!2sbd" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        ]);
    }
}
