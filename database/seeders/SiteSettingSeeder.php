<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            'site_name'        => 'cstees',
            'site_tagline'     => 'Wear the Story',
            'site_email'       => 'support@cstees.com',
            'site_phone'       => '+91 99999 99999',
            'site_address'     => 'Studio 4B, Park Street, Kolkata 700016, India',
            'currency_code'    => 'INR',
            'currency_symbol'  => '₹',

            // Topbar
            'topbar_offer_text' => '25%off Today',
            'topbar_is_active'  => '1',

            // Shipping
            'default_shipping_fee'    => '79',
            'free_shipping_threshold' => '999',
            'shipping_note'           => 'Standard delivery: 3–5 business days across India.',

            // Tax
            'tax_rate'       => '18',
            'tax_label'      => 'GST',
            'tax_inclusive'  => '0',

            // Social
            'facebook_url'  => 'https://facebook.com/cstees',
            'instagram_url' => 'https://instagram.com/cstees',
            'twitter_url'   => 'https://twitter.com/cstees',
            'youtube_url'   => 'https://youtube.com/@cstees',
            'pinterest_url' => 'https://pinterest.com/cstees',

            // SEO
            'meta_title_default'       => 'cstees | Premium Graphic Essentials from Kolkata',
            'meta_description_default' => 'Premium graphic essentials designed in-house in Kolkata, India. Discover our latest tee drops, soft layers, and weekend icons.',
            'google_analytics_id'      => '',

            // Mail
            'mail_from_address' => 'noreply@cstees.com',
            'mail_from_name'    => 'cstees',

            // Payments
            'payment_cod_enabled'        => '1',
            'payment_card_enabled'       => '1',
            'payment_upi_enabled'        => '1',
            'payment_netbanking_enabled' => '1',
            'payment_wallet_enabled'     => '0',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget('site_settings');

        $this->command->info('Site settings seeded (' . count($settings) . ' keys).');
    }
}
