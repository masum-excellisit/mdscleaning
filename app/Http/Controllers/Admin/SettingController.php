<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Whitelisted setting keys grouped by tab.
     */
    protected array $groups = [
        'general' => [
            'site_name', 'site_tagline', 'site_email', 'site_phone', 'site_address',
            'currency_symbol', 'currency_code',
        ],
        'topbar' => [
            'topbar_offer_text', 'topbar_is_active',
        ],
        'shipping' => [
            'free_shipping_threshold', 'default_shipping_fee', 'shipping_note',
        ],
        'tax' => [
            'tax_rate', 'tax_label', 'tax_inclusive',
        ],
        'social' => [
            'facebook_url', 'instagram_url', 'twitter_url', 'youtube_url', 'pinterest_url',
        ],
        'seo' => [
            'meta_title_default', 'meta_description_default', 'google_analytics_id',
        ],
        'mail' => [
            'mail_from_address', 'mail_from_name',
        ],
        'payments' => [
            'payment_cod_enabled', 'payment_card_enabled', 'payment_upi_enabled', 'payment_netbanking_enabled', 'payment_wallet_enabled',
        ],
    ];

    public function __construct(protected MediaService $media) {}

    public function index(): View
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        $groups   = $this->groups;
        return view('admin.settings.index', compact('settings', 'groups'));
    }

    public function update(Request $request): RedirectResponse
    {
        // Flatten allowed keys
        $allowedKeys = collect($this->groups)->flatten()->values()->all();
        $allowedKeys = array_merge($allowedKeys, ['logo', 'favicon']);

        $payload = $request->only($allowedKeys);

        foreach ($payload as $key => $value) {
            if ($value === null) continue;
            SiteSetting::set($key, $value);
        }

        // Logo / favicon uploads
        foreach (['logo', 'favicon'] as $imageKey) {
            if ($request->hasFile($imageKey)) {
                $request->validate([$imageKey => ['image', 'max:2048']]);
                $existing = SiteSetting::get($imageKey);
                if ($existing && ! str_starts_with($existing, 'http')) {
                    $this->media->delete($existing);
                }
                $path = $this->media->store($request->file($imageKey), 'site', null);
                SiteSetting::set($imageKey, $path);
            }
            if ($request->boolean("remove_{$imageKey}")) {
                if (($existing = SiteSetting::get($imageKey)) && ! str_starts_with($existing, 'http')) {
                    $this->media->delete($existing);
                }
                SiteSetting::set($imageKey, '');
            }
        }

        Cache::forget('site_settings');

        return back()->with('success', 'Settings saved.');
    }
}
