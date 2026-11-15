<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_category_id',
        'name',
        'slug',
        'location',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(InstitutionCategory::class, 'institution_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(InstitutionImage::class)->orderBy('order', 'asc');
    }

    public function members(): HasMany
    {
        return $this->hasMany(InstitutionMember::class)->orderBy('order', 'asc');
    }

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
        static::saving(function ($institution) {
            if (empty($institution->slug)) {
                $base = Str::slug($institution->name);
                if (empty($base)) {
                    $base = 'institution-' . uniqid();
                }
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $institution->id ?? 0)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $institution->slug = $slug;
            }
        });
    }
}

