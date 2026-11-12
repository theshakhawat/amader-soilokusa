<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'short_description',
        'description',
        'image',
        'button_text',
    ];

    /**
     * Get image url safely.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        if (file_exists(public_path('assets/images/about-shaheed-minar.jpg'))) {
            return asset('assets/images/about-shaheed-minar.jpg');
        }
        return 'https://placehold.co/800x600/0b4622/ffffff?text=About+Us';
    }
}
