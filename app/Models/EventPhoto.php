<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class EventPhoto extends Model
{
    use HasFactory;

    protected $table = 'event_photos';

    protected $fillable = [
        'event_id',
        'photo',
        'caption',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return Storage::disk('public')->url($this->photo);
        }

        if ($this->photo && (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://'))) {
            return $this->photo;
        }

        return asset('assets/images/event-1.jpg');
    }
}
