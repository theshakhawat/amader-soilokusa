<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'status',
        'description',
        'order_index',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function files(): HasMany
    {
        return $this->hasMany(NoticeFile::class, 'notice_id');
    }

    // Bangla Formatted Date
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

