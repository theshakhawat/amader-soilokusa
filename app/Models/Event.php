<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'thumbnail',
        'date',
        'time',
        'location',
        'status',
        'description',
        'order_index',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(EventPhoto::class, 'event_id');
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            return Storage::disk('public')->url($this->thumbnail);
        }

        if ($this->thumbnail && (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://'))) {
            return $this->thumbnail;
        }

        return asset('assets/images/event-1.jpg');
    }

    // Bangla Day helper
    public function getBanglaDayAttribute(): string
    {
        if (!$this->date) return '০১';
        $day = $this->date->format('d');
        return $this->convertToBanglaDigits($day);
    }

    // Bangla Month helper
    public function getBanglaMonthAttribute(): string
    {
        if (!$this->date) return 'জানুঃ';
        $months = [
            'Jan' => 'জানুঃ',
            'Feb' => 'ফেব্রুঃ',
            'Mar' => 'মার্চ',
            'Apr' => 'এপ্রিল',
            'May' => 'মে',
            'Jun' => 'জুন',
            'Jul' => 'জুলাই',
            'Aug' => 'আগস্ট',
            'Sep' => 'সেপ্টেঃ',
            'Oct' => 'অক্টোঃ',
            'Nov' => 'নভেঃ',
            'Dec' => 'ডিসেঃ'
        ];
        $enMonth = $this->date->format('M');
        return $months[$enMonth] ?? $enMonth;
    }

    // Bangla Full Date helper
    public function getBanglaFormattedDateAttribute(): string
    {
        if (!$this->date) return '';
        $day = $this->convertToBanglaDigits($this->date->format('d'));
        $year = $this->convertToBanglaDigits($this->date->format('Y'));
        
        $months = [
            1 => 'জানুয়ারি', 2 => 'ফেব্রুয়ারি', 3 => 'মার্চ', 4 => 'এপ্রিল',
            5 => 'মে', 6 => 'জুন', 7 => 'জুলাই', 8 => 'আগস্ট',
            9 => 'সেপ্টেম্বর', 10 => 'অক্টোবর', 11 => 'নভেম্বর', 12 => 'ডিসেম্বর'
        ];
        $m = (int) $this->date->format('n');
        $monthName = $months[$m] ?? '';

        return "{$day} {$monthName} {$year}";
    }

    private function convertToBanglaDigits(string $number): string
    {
        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        return str_replace($en, $bn, $number);
    }
}
