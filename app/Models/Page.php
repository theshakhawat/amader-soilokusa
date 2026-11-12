<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $baseSlug = Str::slug($page->title);
                if (empty($baseSlug)) {
                    $baseSlug = 'page-' . time();
                }
                $slug = $baseSlug;
                $count = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $page->slug = $slug;
            }
        });

        static::updating(function ($page) {
            if ($page->isDirty('title') && empty($page->slug)) {
                $baseSlug = Str::slug($page->title);
                if (empty($baseSlug)) {
                    $baseSlug = 'page-' . time();
                }
                $slug = $baseSlug;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $page->id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $page->slug = $slug;
            }
        });
    }
}
