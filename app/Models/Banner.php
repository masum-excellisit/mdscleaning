<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_url',
        'image',
        'is_active',
        'sort_order',
        'page',
    ];

    protected function casts(): array
    {
        return [
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeForPage(Builder $q, string $page): Builder
    {
        return $q->where('page', $page);
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return asset('assets/images/banner-placeholder.jpg');
        }
        if (str_starts_with($this->image, 'http') || str_starts_with($this->image, '/') || str_starts_with($this->image, 'assets/')) {
            return asset(ltrim($this->image, '/'));
        }
        return Storage::url($this->image);
    }
}
