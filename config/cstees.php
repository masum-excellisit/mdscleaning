<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cstees Project Configuration
    |--------------------------------------------------------------------------
    |
    | Project-specific config used by services, controllers, and views.
    | Most of these can be overridden by site_settings entries (admin panel).
    |
    */

    'brand' => [
        'name'     => 'Cstees',
        'tagline'  => 'Wear the Story',
        'location' => 'Kolkata, India',
    ],

    'currency' => [
        'code'   => env('CSTEES_CURRENCY', 'INR'),
        'symbol' => env('CSTEES_CURRENCY_SYMBOL', '₹'),
    ],

    'shipping' => [
        'default_fee'            => (float) env('CSTEES_DEFAULT_SHIPPING_FEE', 79),
        'free_shipping_threshold' => (float) env('CSTEES_FREE_SHIPPING_THRESHOLD', 999),
    ],

    'tax' => [
        'rate'      => (float) env('CSTEES_TAX_RATE', 18),
        'label'     => env('CSTEES_TAX_LABEL', 'GST'),
        'inclusive' => (bool) env('CSTEES_TAX_INCLUSIVE', false),
    ],

    'order' => [
        'prefix'           => env('CSTEES_ORDER_PREFIX', 'CST'),
        'number_format'    => 'PREFIX-Ymd-00000',
        'cancellable_for'  => ['pending', 'processing'],
    ],

    'inventory' => [
        'low_stock_threshold' => 10,
    ],

    'pagination' => [
        'shop'          => 12,
        'admin_table'   => 20,
        'admin_orders'  => 25,
        'blog'          => 9,
        'wishlist'      => 12,
    ],

    'media' => [
        'allowed_mime'   => ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
        'max_size_kb'    => 4096,
        'product_resize' => [800, 800],
        'banner_resize'  => [1920, 700],
        'blog_resize'    => [1200, 630],
    ],

    'colors' => [
        'primary'       => '#79afe3',
        'primary_dark'  => '#4e87c3',
        'primary_light' => '#d9ebff',
        'accent_light'  => '#d5e9ff',
        'accent_yellow' => '#fff4c2',
        'accent_pink'   => '#d15378',
        'dark'          => '#16324a',
        'muted'         => '#607487',
        'border'        => '#d7e6f5',
        'body_bg'       => '#edf6ff',
    ],

    'social' => [
        'facebook'  => null,
        'instagram' => null,
        'twitter'   => null,
        'youtube'   => null,
        'pinterest' => null,
    ],

    'roles' => [
        'super-admin',
        'admin',
        'manager',
        'content-editor',
        'order-manager',
        'customer',
    ],

];
