<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'thumbnail',
        'content',
        'status',
        'published',
    ];

    protected $casts = [
        'status' => 'boolean',
        'published' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title) . '-' . rand(100, 999);
            }
            if (empty($post->published)) {
                $post->published = now();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            return Storage::disk('public')->url($this->thumbnail);
        }

        if ($this->thumbnail && (
            str_starts_with($this->thumbnail, 'http://') ||
            str_starts_with($this->thumbnail, 'https://') ||
            str_starts_with($this->thumbnail, 'assets/')
        )) {
            return asset($this->thumbnail);
        }

        return asset('assets/images/blog-1.jpg');
    }
}

