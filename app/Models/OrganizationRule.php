<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrganizationRule extends Model
{
    use HasFactory;

    protected $table = 'organization_rules';

    protected $fillable = [
        'part_no',
        'title',
        'slug',
        'summary',
        'content',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order'  => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rule) {
            if (empty($rule->slug)) {
                $base = Str::slug($rule->part_no . '-' . $rule->title);
                if (empty($base)) {
                    $base = 'part-' . time();
                }
                $rule->slug = $base;
            }
        });
    }

    /**
     * Scope for active rules ordered by order asc.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('order', 'asc')->orderBy('id', 'asc');
    }
}
