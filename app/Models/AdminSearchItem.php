<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class AdminSearchItem extends Model
{
    use HasFactory;

    protected $table = 'admin_search_items';

    protected $fillable = [
        'title_bn',
        'title_en',
        'group_name',
        'keywords',
        'route_name',
        'url',
        'icon',
        'badge',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    /**
     * Get computed target URL.
     */
    public function getTargetUrlAttribute(): string
    {
        if (!empty($this->route_name) && Route::has($this->route_name)) {
            return route($this->route_name);
        }

        if (!empty($this->url)) {
            return $this->url;
        }

        return '#';
    }
}
