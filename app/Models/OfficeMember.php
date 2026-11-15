<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfficeMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id',
        'name',
        'designation',
        'photo',
        'phone',
        'email',
        'qualification',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(public_path('storage/' . $this->photo))) {
            return asset('storage/' . $this->photo);
        }
        if ($this->photo && file_exists(public_path($this->photo))) {
            return asset($this->photo);
        }
        return 'https://placehold.co/300x300/0b4622/ffffff?text=' . urlencode($this->name);
    }
}

