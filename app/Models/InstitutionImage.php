<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstitutionImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'image_path',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function getUrlAttribute(): string
    {
        if ($this->image_path && file_exists(public_path('storage/' . $this->image_path))) {
            return asset('storage/' . $this->image_path);
        }
        if ($this->image_path && file_exists(public_path($this->image_path))) {
            return asset($this->image_path);
        }
        return asset($this->image_path);
    }
}

