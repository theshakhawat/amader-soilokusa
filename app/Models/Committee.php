<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Committee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'session_duration',
        'subtitle',
        'image',
        'description',
        'is_active',
        'second_row_count',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'second_row_count' => 'integer',
    ];

    /**
     * Relationship with Committee Members.
     */
    public function members(): HasMany
    {
        return $this->hasMany(CommitteeMember::class)->orderBy('order', 'asc');
    }

    /**
     * Get image URL with fallback.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        return asset('assets/images/committee.jpg');
    }

    protected static function booted()
    {
        static::saving(function ($committee) {
            if (empty($committee->slug)) {
                $base = Str::slug($committee->name);
                if (empty($base)) {
                    $base = 'committee-' . uniqid();
                }
                $slug = $base;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $committee->id ?? 0)->exists()) {
                    $slug = $base . '-' . $count++;
                }
                $committee->slug = $slug;
            }
        });
    }
}
