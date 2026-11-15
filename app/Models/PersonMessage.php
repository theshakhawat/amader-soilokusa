<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PersonMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'slug',
        'name',
        'designation',
        'image',
        'quote',
        'message',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order'  => 'integer',
    ];

    /**
     * Legacy English-key to Bengali label map.
     */
    public static function typeLabels(): array
    {
        return [
            'adviser'   => 'উপদেষ্টা বাণী',
            'patron'    => 'পৃষ্ঠপোষকের বাণী',
            'president' => 'সভাপতির বাণী',
            'executive' => 'কার্যনির্বাহীর বাণী',
            'other'     => 'অন্যান্য বিশিষ্ট ব্যক্তির বাণী',
        ];
    }

    /**
     * Default popular type suggestions.
     */
    public static function defaultTypes(): array
    {
        return [
            'উপদেষ্টা বাণী',
            'পৃষ্ঠপোষকের বাণী',
            'সভাপতির বাণী',
            'কার্যনির্বাহীর বাণী',
            'প্রধান অতিথির বাণী',
            'বিশেষ ব্যক্তিত্বের বাণী',
        ];
    }

    /**
     * Display label for type.
     */
    public function getTypeLabelAttribute(): string
    {
        $map = static::typeLabels();

        return $map[$this->type] ?? $this->type;
    }

    /**
     * Safe image url.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        return 'https://placehold.co/400x400/0b4622/ffffff?text=' . urlencode($this->name);
    }

    protected static function booted()
    {
        static::saving(function ($item) {
            if (empty($item->slug)) {
                $baseSlug = Str::slug($item->type . '-' . $item->name);
                if (empty($baseSlug)) {
                    $baseSlug = 'message-' . uniqid();
                }
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->where('id', '!=', $item->id ?? 0)->exists()) {
                    $slug = $baseSlug . '-' . $counter++;
                }
                $item->slug = $slug;
            }
        });
    }
}
