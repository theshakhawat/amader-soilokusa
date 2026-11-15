<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstitutionMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
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

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
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

