<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopbarSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active',
        'show_contact',
        'show_social',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_contact' => 'boolean',
        'show_social' => 'boolean',
    ];
}
