<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'count',
        'icon',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
    ];
}
