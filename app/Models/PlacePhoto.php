<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PlacePhoto extends Model
{
    use HasFactory;

    protected $table = 'place_photos';

    protected $fillable = [
        'place_id',
        'image',
        'order_index',
    ];

    protected $casts = [
        'order_index' => 'integer',
    ];

    /**
     * Relationship: belongs to a Place.
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Accessor: returns a full public URL for the photo.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        if ($this->image && (
            str_starts_with($this->image, 'http://') ||
            str_starts_with($this->image, 'https://') ||
            str_starts_with($this->image, 'assets/')
        )) {
            return asset($this->image);
        }

        return asset('assets/images/place-default.jpg');
    }
}

