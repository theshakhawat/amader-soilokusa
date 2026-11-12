<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Place extends Model
{
    use HasFactory;

    protected $table = 'places';

    protected $fillable = [
        'title',
        'subtitle',
        'thumbnail',
        'location',
        'descriptions',
        'status',
        'order_index',
    ];

    protected $casts = [
        'status'      => 'boolean',
        'order_index' => 'integer',
    ];

    /**
     * Relationship: a place has many photos.
     */
    public function photos()
    {
        return $this->hasMany(PlacePhoto::class)->orderBy('order_index', 'asc');
    }

    /**
     * Accessor: returns a full public URL for the thumbnail.
     */
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

        return asset('assets/images/place-default.jpg');
    }
}

