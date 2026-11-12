<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteeMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'committee_id',
        'name',
        'title',
        'photo',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
    ];

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    /**
     * Get photo URL with fallback.
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(public_path('storage/' . $this->photo))) {
            return asset('storage/' . $this->photo);
        }
        if ($this->photo && file_exists(public_path($this->photo))) {
            return asset($this->photo);
        }
        return asset('assets/images/user-avatar.png');
    }
}
