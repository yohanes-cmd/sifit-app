<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'file_path',
        'youtube_url',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->latest();
    }

    /**
     * Get formatted YouTube embed URL if type is video and youtube_url is present.
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (empty($this->youtube_url)) {
            return null;
        }

        $url = $this->youtube_url;

        // Check for standard watch URL: https://www.youtube.com/watch?v=XXXX
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        return $url;
    }

    /**
     * Get YouTube thumbnail if youtube_url is set.
     */
    public function getYoutubeThumbnailUrlAttribute(): ?string
    {
        if (empty($this->youtube_url)) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $this->youtube_url, $matches)) {
            return 'https://img.youtube.com/vi/'.$matches[1].'/hqdefault.jpg';
        }

        return null;
    }

    /**
     * Resolved media display URL (image/thumbnail/video).
     */
    public function getMediaUrlAttribute(): string
    {
        if ($this->file_path && file_exists(public_path('storage/'.$this->file_path))) {
            return asset('storage/'.$this->file_path);
        }

        if ($this->type === 'video' && $this->youtube_thumbnail_url) {
            return $this->youtube_thumbnail_url;
        }

        return asset('assets/images/news-default.svg');
    }
}
