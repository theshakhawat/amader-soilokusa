<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DonationSetting extends Model
{
    use HasFactory;

    protected $table = 'donation_settings';

    protected $fillable = [
        'title',
        'description',
        'button_text',
        'button_link',
        'image',
        'icon',
        'bg_color_start',
        'bg_color_end',
        'text_color',
        'button_bg_color',
        'button_text_color',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        if ($this->image && (
            str_starts_with($this->image, 'http://') ||
            str_starts_with($this->image, 'https://') ||
            str_starts_with($this->image, 'assets/')
        )) {
            return asset($this->image);
        }

        return asset('assets/images/donate-sapling.jpg');
    }

    /**
     * Get computed linear or radial background gradient style
     */
    public function getBackgroundGradientAttribute(): string
    {
        $start = $this->bg_color_start ?: '#d92638';
        $end = $this->bg_color_end ?: '#7d0615';

        return "radial-gradient(circle at 78% 45%, {$start} 0%, {$end} 100%)";
    }
}
