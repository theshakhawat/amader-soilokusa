<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresidentMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'designation',
        'quote',
        'message',
        'image',
    ];

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
        if (file_exists(public_path('assets/images/president.jpg'))) {
            return asset('assets/images/president.jpg');
        }
        return 'https://placehold.co/400x400/0b4622/ffffff?text=President';
    }
}
