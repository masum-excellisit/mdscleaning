<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugService
{
    /**
     * Generate a unique slug for a given table column.
     *
     * @param  string  $modelClass  Eloquent model class
     * @param  string  $source      The text to slugify (e.g. product name)
     * @param  string  $column      Column name to check uniqueness against (default 'slug')
     * @param  int|null $ignoreId   Existing model ID to ignore (during update)
     */
    public function generate(string $modelClass, string $source, string $column = 'slug', ?int $ignoreId = null): string
    {
        $base = Str::slug($source);
        if ($base === '') {
            $base = 'item-' . Str::lower(Str::random(6));
        }

        $slug = $base;
        $i = 1;

        while ($this->exists($modelClass, $column, $slug, $ignoreId)) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }

    protected function exists(string $modelClass, string $column, string $slug, ?int $ignoreId): bool
    {
        /** @var Model $modelClass */
        $q = $modelClass::where($column, $slug);
        if ($ignoreId) {
            $q->where('id', '!=', $ignoreId);
        }
        return $q->exists();
    }

    /**
     * Generate a unique SKU. Format: PREFIX-XXXX (alphanumeric).
     */
    public function generateSku(string $modelClass, string $base, string $column = 'sku'): string
    {
        $base = Str::upper(Str::slug($base, ''));
        $base = substr($base, 0, 12);
        if ($base === '') $base = 'SKU';

        $candidate = $base . '-' . strtoupper(Str::random(4));

        /** @var Model $modelClass */
        while ($modelClass::where($column, $candidate)->exists()) {
            $candidate = $base . '-' . strtoupper(Str::random(4));
        }

        return $candidate;
    }
}
