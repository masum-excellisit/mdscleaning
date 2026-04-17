<?php

use App\Models\SiteSetting;

if (! function_exists('setting')) {
    /**
     * Get a site setting value, falling back to the given default.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        try {
            return SiteSetting::get($key, $default);
        } catch (\Throwable $e) {
            return $default;
        }
    }
}

if (! function_exists('format_price')) {
    /**
     * Format a numeric value as a price string with the configured currency symbol.
     */
    function format_price(float|int|string|null $amount, ?string $symbol = null): string
    {
        $symbol = $symbol ?? config('cstees.currency.symbol', '₹');
        $value  = number_format((float) ($amount ?? 0), 2, '.', ',');
        return $symbol . $value;
    }
}

if (! function_exists('cstees_currency')) {
    function cstees_currency(): string
    {
        return config('cstees.currency.symbol', '₹');
    }
}

if (! function_exists('active_class')) {
    /**
     * Return the active CSS class if the current route name matches the given pattern(s).
     */
    function active_class(string|array $patterns, string $class = 'active'): string
    {
        $patterns = (array) $patterns;
        return request()->routeIs(...$patterns) ? $class : '';
    }
}

if (! function_exists('active_when')) {
    function active_when(bool $condition, string $class = 'active'): string
    {
        return $condition ? $class : '';
    }
}

if (! function_exists('cart_count')) {
    /**
     * Quick cart-item count for header badge. Returns 0 if anything goes wrong.
     */
    function cart_count(): int
    {
        try {
            if (auth()->check()) {
                $cart = auth()->user()->cart()->with('items')->first();
            } else {
                $sessionId = session()->getId();
                $cart = \App\Models\Cart::where('session_id', $sessionId)->with('items')->first();
            }
            return (int) ($cart?->items?->sum('qty') ?? 0);
        } catch (\Throwable $e) {
            return 0;
        }
    }
}

if (! function_exists('wishlist_count')) {
    function wishlist_count(): int
    {
        try {
            return auth()->check() ? auth()->user()->wishlists()->count() : 0;
        } catch (\Throwable $e) {
            return 0;
        }
    }
}
