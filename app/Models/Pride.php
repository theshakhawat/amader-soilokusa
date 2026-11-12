<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pride extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'photo',
        'description',
        'order_index',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order_index' => 'integer',
    ];

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return Storage::disk('public')->url($this->photo);
        }

        if ($this->photo && (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://') || str_starts_with($this->photo, 'assets/'))) {
            return asset($this->photo);
        }

        return 'https://placehold.co/400x400/0b4622/ffffff?text=' . urlencode($this->name);
    }
}
