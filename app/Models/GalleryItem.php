<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryItem extends Model
{
    use HasFactory;

    protected $table = 'gallery_items';

    protected $fillable = [
        'type',
        'title',
        'file_path',
        'video_url',
        'thumbnail',
        'status',
        'order_index',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order_index' => 'integer',
    ];

    /**
     * Get image URL (for photo)
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->file_path && Storage::disk('public')->exists($this->file_path)) {
            return Storage::disk('public')->url($this->file_path);
        }

        if ($this->file_path && (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://') || str_starts_with($this->file_path, 'assets/'))) {
            return asset($this->file_path);
        }

        return asset('assets/images/event-1.jpg');
    }

    /**
     * Get video display thumbnail URL
     */
    public function getVideoThumbnailAttribute(): string
    {
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            return Storage::disk('public')->url($this->thumbnail);
        }

        if ($this->thumbnail && (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://'))) {
            return $this->thumbnail;
        }

        // Try extracting YouTube ID if video_url is a YouTube link
        if ($this->video_url) {
            $youtubeId = $this->extractYoutubeId($this->video_url);
            if ($youtubeId) {
                return "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg";
            }
        }

        if ($this->file_path) {
            return $this->image_url;
        }

        return asset('assets/images/event-2.jpg');
    }

    /**
     * Determine if this video is a locally uploaded video file
     */
    public function getIsLocalVideoAttribute(): bool
    {
        return $this->type === 'video' && !empty($this->file_path) && empty($this->video_url);
    }

    /**
     * Get embeddable video URL for iframe or direct video src
     */
    public function getEmbedUrlAttribute(): ?string
    {
        if ($this->is_local_video) {
            return Storage::disk('public')->exists($this->file_path) 
                ? Storage::disk('public')->url($this->file_path) 
                : asset($this->file_path);
        }

        if (!$this->video_url) {
            return $this->file_path ? Storage::disk('public')->url($this->file_path) : null;
        }

        $youtubeId = $this->extractYoutubeId($this->video_url);
        if ($youtubeId) {
            return "https://www.youtube-nocookie.com/embed/{$youtubeId}?autoplay=1&rel=0";
        }

        return $this->video_url;
    }

    public function extractYoutubeId(?string $url): ?string
    {
        if (!$url) return null;
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
