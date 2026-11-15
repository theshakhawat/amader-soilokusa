<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'trx_id',
        'donor_name',
        'donor_phone',
        'donor_email',
        'amount',
        'currency',
        'payment_method',
        'gateway_trx_id',
        'status',
        'payment_response',
        'paid_at',
        'is_manual',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_response' => 'array',
        'paid_at' => 'datetime',
        'is_manual' => 'boolean',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isSuccess(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isFailed(): bool
    {
        return in_array($this->status, [self::STATUS_FAILED, self::STATUS_CANCELLED], true);
    }

    /**
     * Generate unique transaction ID for donations (e.g. DN741852).
     */
    public static function generateTrxId(): string
    {
        do {
            $trx = 'DN' . strtoupper(substr(md5(uniqid((string)mt_rand(), true)), 0, 8));
        } while (static::where('trx_id', $trx)->exists());

        return $trx;
    }
}

