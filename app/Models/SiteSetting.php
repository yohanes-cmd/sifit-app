<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
    ];

    /**
     * Get a setting value by key with fallback.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        return Cache::rememberForever("site_setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting && $setting->value !== null && $setting->value !== '' ? $setting->value : $default;
        });
    }

    /**
     * Set / update a setting value by key.
     */
    public static function set(string $key, ?string $value, string $group = 'general', ?string $label = null): self
    {
        Cache::forget("site_setting_{$key}");

        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'label' => $label ?? ucwords(str_replace('_', ' ', $key)),
            ]
        );
    }

    /**
     * Clear all cached settings.
     */
    public static function clearCache(): void
    {
        Cache::forget('site_settings_all');
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("site_setting_{$key}");
        }
    }
}
