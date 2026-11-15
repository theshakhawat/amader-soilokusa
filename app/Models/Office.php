<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'location',
        'image',
        'description',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order'  => 'integer',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(OfficeMember::class)->orderBy('order', 'asc');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        return 'https://placehold.co/800x500/0b4622/ffffff?text=' . urlencode($this->name);
    }

    protected static function booted()
    {
        static::saving(function ($office) {
            if (empty($office->slug)) {
                $base = Str::slug($office->name);
                if (empty($base)) {
                    $base = 'office-' . uniqid();
                }
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $office->id ?? 0)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $office->slug = $slug;
            }
        });
    }
}

