<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'project_status',
        'description',
        'status',
        'order_index',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order_index' => 'integer',
    ];

    public function photos()
    {
        return $this->hasMany(ProjectPhoto::class)->orderBy('order_index', 'asc');
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            return Storage::disk('public')->url($this->thumbnail);
        }

        if ($this->thumbnail && (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://') || str_starts_with($this->thumbnail, 'assets/'))) {
            return asset($this->thumbnail);
        }

        return asset('assets/images/project-road.jpg');
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->project_status) {
            'running' => [
                'text' => 'চলমান প্রকল্প',
                'bg' => 'bg-emerald-500',
                'text_color' => 'text-white',
                'border' => 'border-emerald-600',
                'icon' => 'ri-loader-4-line',
            ],
            'completed' => [
                'text' => 'সম্পন্ন প্রকল্প',
                'bg' => 'bg-blue-600',
                'text_color' => 'text-white',
                'border' => 'border-blue-700',
                'icon' => 'ri-checkbox-circle-line',
            ],
            'upcoming' => [
                'text' => 'আসন্ন প্রকল্প',
                'bg' => 'bg-amber-500',
                'text_color' => 'text-white',
                'border' => 'border-amber-600',
                'icon' => 'ri-time-line',
            ],
            default => [
                'text' => 'প্রকল্প',
                'bg' => 'bg-gray-600',
                'text_color' => 'text-white',
                'border' => 'border-gray-700',
                'icon' => 'ri-stack-line',
            ]
        };
    }
}

