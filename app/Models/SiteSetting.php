<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    use HasFactory;

    protected $table = 'site_settings';

    protected $fillable = [
        'site_title',
        'site_tagline',
        'header_logo',
        'footer_logo',
        'favicon',
    ];

    public function getHeaderLogoUrlAttribute(): string
    {
        if ($this->header_logo && Storage::disk('public')->exists($this->header_logo)) {
            return Storage::disk('public')->url($this->header_logo);
        }
        if ($this->header_logo && (str_starts_with($this->header_logo, 'http') || str_starts_with($this->header_logo, 'assets/'))) {
            return asset($this->header_logo);
        }
        return asset('assets/images/logo-icon.png');
    }

    public function getFooterLogoUrlAttribute(): string
    {
        if ($this->footer_logo && Storage::disk('public')->exists($this->footer_logo)) {
            return Storage::disk('public')->url($this->footer_logo);
        }
        if ($this->footer_logo && (str_starts_with($this->footer_logo, 'http') || str_starts_with($this->footer_logo, 'assets/'))) {
            return asset($this->footer_logo);
        }
        return $this->header_logo_url;
    }

    public function getFaviconUrlAttribute(): ?string
    {
        if ($this->favicon && Storage::disk('public')->exists($this->favicon)) {
            return Storage::disk('public')->url($this->favicon);
        }
        if ($this->favicon && (str_starts_with($this->favicon, 'http') || str_starts_with($this->favicon, 'assets/'))) {
            return asset($this->favicon);
        }
        return asset('assets/images/logo-icon.png');
    }
}

