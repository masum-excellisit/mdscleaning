<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'description',
        'features',
        'icon_class',
        'image',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'features'   => 'array',
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return asset('assets/images/service-residential.jpg');
        }
        if (str_starts_with($this->image, 'http') || str_starts_with($this->image, '/') || str_starts_with($this->image, 'assets/')) {
            return asset(ltrim($this->image, '/'));
        }
        return Storage::url($this->image);
    }
}
