<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'title',
        'url',
        'target',
        'icon',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order'  => 'integer',
    ];

    /**
     * Parent Nav Item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(NavItem::class, 'parent_id');
    }

    /**
     * Direct Child Nav Items.
     */
    public function children(): HasMany
    {
        return $this->hasMany(NavItem::class, 'parent_id')->orderBy('order', 'asc');
    }

    /**
     * Active Children.
     */
    public function activeChildren(): HasMany
    {
        return $this->children()->where('status', true);
    }
}

