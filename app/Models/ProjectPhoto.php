<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectPhoto extends Model
{
    use HasFactory;

    protected $table = 'project_photos';

    protected $fillable = [
        'project_id',
        'image_path',
        'caption',
        'order_index',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            return Storage::disk('public')->url($this->image_path);
        }

        if ($this->image_path && (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://') || str_starts_with($this->image_path, 'assets/'))) {
            return asset($this->image_path);
        }

        return asset('assets/images/project-road.jpg');
    }
}

