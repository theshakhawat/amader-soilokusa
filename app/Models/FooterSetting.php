<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_title',
        'brand_subtitle',
        'about_text',
        'show_social_links',
        'quick_links_title',
        'quick_links',
        'important_links_title',
        'important_links',
        'contact_title',
        'copyright_text',
        'privacy_policy_text',
        'privacy_policy_link',
        'terms_text',
        'terms_link',
    ];

    protected $casts = [
        'show_social_links' => 'boolean',
        'quick_links' => 'array',
        'important_links' => 'array',
    ];
}
