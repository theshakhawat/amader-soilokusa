<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Member extends Model
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
     * Auto-generate unique uuid, slug and default id_card_number if missing.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($member) {
            if (empty($member->uuid)) {
                $member->uuid = (string) Str::uuid();
            }

            if (empty($member->slug)) {
                $baseSlug = Str::slug($member->name);
                if (empty($baseSlug)) {
                    $baseSlug = 'member';
                }
                $slug = $baseSlug . '-' . Str::lower(Str::random(6));
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . Str::lower(Str::random(6));
                }
                $member->slug = $slug;
            }

            if (empty($member->id_card_number)) {
                $year = date('Y');
                $nextId = (static::max('id') ?? 0) + 1;
                $member->id_card_number = 'ASM-' . $year . '-' . str_pad((string)$nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * User who approved this member.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * User who manually registered this member from admin.
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
     * Get official formatted Member ID card number.
     */
    public function getCardIdNumberAttribute(): string
    {
        if (!empty($this->attributes['id_card_number'])) {
            return $this->attributes['id_card_number'];
        }

        $year = $this->approved_at ? $this->approved_at->format('Y') : ($this->created_at ? $this->created_at->format('Y') : date('Y'));
        return 'ASM-' . $year . '-' . str_pad((string)$this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get public URL for digital member ID card (using UUID as requested).
     */
    public function getPublicCardUrlAttribute(): string
    {
        return route('members.card', $this->uuid ?: $this->slug);
    }

    /**
     * Scope for approved members.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    /**
     * Scope for pending members.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', false);
    }
}
