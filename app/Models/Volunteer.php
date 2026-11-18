<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'id_card_number',
        'photo',
        'phone',
        'email',
        'blood_group',
        'occupation',
        'address',
        'permanent_address',
        'status',
        'approved_at',
        'approved_by',
        'created_by',
        'notes',
        'signature',
    ];

    protected $casts = [
        'status' => 'boolean',
        'approved_at' => 'datetime',
    ];

    /**
     * Boot function to generate uuid, slug and default id_card_number if missing.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($volunteer) {
            if (empty($volunteer->uuid)) {
                $volunteer->uuid = (string) Str::uuid();
            }

            if (empty($volunteer->slug)) {
                $baseSlug = Str::slug($volunteer->name);
                if (empty($baseSlug)) {
                    $baseSlug = 'volunteer';
                }
                $slug = $baseSlug . '-' . Str::lower(Str::random(6));
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . Str::lower(Str::random(6));
                }
                $volunteer->slug = $slug;
            }

            if (empty($volunteer->id_card_number)) {
                $year = date('Y');
                $nextId = (static::max('id') ?? 0) + 1;
                $volunteer->id_card_number = 'ASV-' . $year . '-' . str_pad((string)$nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * User who approved this volunteer.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * User who manually registered this volunteer (if done from admin).
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get photo URL or fallback avatar.
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return '/storage/' . $this->photo;
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0b4622&color=ffffff&bold=true';
    }

    /**
     * Get authorized signature image URL if uploaded.
     */
    public function getSignatureUrlAttribute(): ?string
    {
        if ($this->signature && Storage::disk('public')->exists($this->signature)) {
            return '/storage/' . $this->signature;
        }

        return null;
    }

    /**
     * Get official ID card number.
     */
    public function getCardIdNumberAttribute(): string
    {
        if (!empty($this->attributes['id_card_number'])) {
            return $this->attributes['id_card_number'];
        }

        $year = $this->approved_at ? $this->approved_at->format('Y') : ($this->created_at ? $this->created_at->format('Y') : date('Y'));
        return 'ASV-' . $year . '-' . str_pad((string)$this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get public URL for digital ID card (using UUID as requested).
     */
    public function getPublicCardUrlAttribute(): string
    {
        return route('volunteers.card', $this->uuid ?: $this->slug);
    }

    /**
     * Scope for approved volunteers.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    /**
     * Scope for pending volunteers.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', false);
    }
}
