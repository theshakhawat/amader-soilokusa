<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnionMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'union_id',
        'name',
        'designation',
        'member_type', // chairman, member, female_member
        'photo',
        'qualification',
        'phone',
        'email',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function union(): BelongsTo
    {
        return $this->belongsTo(Union::class);
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

