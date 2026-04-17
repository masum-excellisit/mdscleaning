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
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site_settings'));
        static::deleted(fn () => Cache::forget('site_settings'));
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::all()->firstWhere('key', $key)?->value ?? $default;
    }

    public static function set(string $key, mixed $value): self
    {
        return self::updateOrCreate(['key' => $key], ['value' => is_array($value) ? json_encode($value) : $value]);
    }

    public static function all($columns = ['*'])
    {
        return Cache::rememberForever('site_settings', fn () => parent::all($columns));
    }
}
