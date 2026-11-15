<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Union extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'location',
        'map_url',
        'phone',
        'email',
        'area_sq_km',
        'population',
        'voter_count',
        'village_count',
        'mouza_count',
        'literacy_rate',
        'status',
        'order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order'  => 'integer',
    ];

    /**
     * Ensure slug is always present.
     */
    public function getSlugAttribute($value): string
    {
        return !empty($value) ? (string)$value : (string)($this->id ?: 'union');
    }

    public function images(): HasMany
    {
        return $this->hasMany(UnionImage::class)->orderBy('order', 'asc');
    }

    public function members(): HasMany
    {
        return $this->hasMany(UnionMember::class)->orderBy('order', 'asc');
    }

    /**
     * Get the Chairman of the Union if exists.
     */
    public function getChairmanAttribute(): ?UnionMember
    {
        return $this->members->first(function ($m) {
            return $m->member_type === 'chairman' || str_contains($m->designation, 'চেয়ারম্যান') || str_contains($m->designation, 'চেয়ারম্যন');
        });
    }

    /**
     * Thumbnail image URL.
     */
    public function getThumbnailUrlAttribute(): string
    {
        $firstImage = $this->images->first();
        if ($firstImage) {
            return $firstImage->url;
        }

        return 'https://placehold.co/600x400/0b4622/ffffff?text=' . urlencode($this->name);
    }

    protected static function booted()
    {
        static::saving(function ($union) {
            if (empty($union->slug)) {
                $base = Str::slug($union->name);
                if (empty($base)) {
                    $base = 'union-' . uniqid();
                }
                $slug = $base;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $union->id ?? 0)->exists()) {
                    $slug = $base . '-' . $count++;
                }
                $union->slug = $slug;
            }
        });
    }
}

