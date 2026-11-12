<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'badge',
        'primary_button_text',
        'primary_button_link',
        'secondary_button_text',
        'secondary_button_link',
        'image',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
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
        return asset('assets/images/hero-shailkupa.jpg');
    }
}
