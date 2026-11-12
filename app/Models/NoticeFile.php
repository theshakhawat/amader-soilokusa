<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class NoticeFile extends Model
{
    use HasFactory;

    protected $table = 'notice_files';

    protected $fillable = [
        'notice_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    public function notice(): BelongsTo
    {
        return $this->belongsTo(Notice::class, 'notice_id');
    }

    public function getFileUrlAttribute(): string
    {
        if ($this->file_path && Storage::disk('public')->exists($this->file_path)) {
            return Storage::disk('public')->url($this->file_path);
        }

        return '#';
    }

    public function getReadableSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if (!$bytes) return '';
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 1) . ' ' . $units[$i];
    }
}

