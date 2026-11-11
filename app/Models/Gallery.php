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
        'status',
        'published_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope for live galleries visible on public frontend.
     * Scheduled items will automatically appear once published_at <= now().
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->where('status', 'published')
                    ->orWhere(function ($sub) {
                        $sub->where('status', 'scheduled')
                            ->where('published_at', '<=', now());
                    });
            })
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderByRaw('COALESCE(published_at, created_at) DESC');
    }

    /**
     * Determine if this gallery item is currently live on frontend.
     */
    public function getIsLiveAttribute(): bool
    {
        if (! $this->is_active || $this->status === 'draft') {
            return false;
        }

        if ($this->status === 'scheduled') {
            return $this->published_at && $this->published_at->isPast();
        }

        if ($this->published_at && $this->published_at->isFuture()) {
            return false;
        }

        return true;
    }

    /**
     * Get computed status label ('published', 'scheduled', 'draft').
     */
    public function getStatusStateAttribute(): string
    {
        if (! $this->is_active || $this->status === 'draft') {
            return 'draft';
        }

        if ($this->published_at && $this->published_at->isFuture()) {
            return 'scheduled';
        }

        return 'published';
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
