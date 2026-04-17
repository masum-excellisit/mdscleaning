<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'content',
        'avatar',
        'rating',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
            'rating'     => 'integer',
        ];
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function getAvatarUrlAttribute(): string
    {
        if (! $this->avatar) {
            return asset('assets/images/client-1.jpg');
        }
        if (str_starts_with($this->avatar, 'http') || str_starts_with($this->avatar, '/') || str_starts_with($this->avatar, 'assets/')) {
            return asset(ltrim($this->avatar, '/'));
        }
        return Storage::url($this->avatar);
    }
}
