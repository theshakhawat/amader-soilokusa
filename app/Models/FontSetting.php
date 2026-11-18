<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FontSetting extends Model
{
    use HasFactory;

    protected $table = 'font_settings';

    protected $fillable = [
        'admin_font_family',
        'admin_font_size',
        'admin_font_weight',
        'admin_font_style',
        'website_font_family',
        'website_font_size',
        'website_font_weight',
        'website_font_style',
        'navbar_font_family',
        'navbar_font_size',
        'navbar_font_weight',
        'navbar_font_style',
        'banner_font_family',
        'banner_font_size',
        'banner_font_weight',
        'banner_font_style',
        'content_font_family',
        'content_font_size',
        'content_font_weight',
        'content_font_style',
    ];

    /**
     * Get or create singleton instance
     */
    public static function getSettings(): self
    {
        return static::firstOrCreate([], [
            'admin_font_family' => 'SolaimanLipi',
            'admin_font_size' => '16px',
            'admin_font_weight' => '700',
            'admin_font_style' => 'normal',
            'website_font_family' => 'SolaimanLipi',
            'website_font_size' => '17px',
            'website_font_weight' => '700',
            'website_font_style' => 'normal',
        ]);
    }
}
