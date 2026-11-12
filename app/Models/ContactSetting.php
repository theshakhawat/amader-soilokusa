<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'phone',
        'email',
        'alt_phone',
        'address',
    ];

    /**
     * Get or create the singleton contact setting record.
     */
    public static function getSettings(): self
    {
        return self::firstOrCreate([], [
            'location' => 'শৈলকুপা',
            'phone' => '+880 1700-123456',
            'email' => 'info@agamirshailkupa.org',
            'alt_phone' => '+880 1800-123456',
            'address' => 'শৈলকুপা, ঝিনাইদহ, বাংলাদেশ',
        ]);
    }
}
