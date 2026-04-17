<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug'  => 'about',
                'title' => 'About cstees',
                'body'  => $this->aboutBody(),
            ],
            [
                'slug'  => 'shipping-policy',
                'title' => 'Shipping Policy',
                'body'  => $this->shippingBody(),
            ],
            [
                'slug'  => 'returns',
                'title' => 'Returns & Refunds',
                'body'  => $this->returnsBody(),
            ],
            [
                'slug'  => 'privacy-policy',
                'title' => 'Privacy Policy',
                'body'  => $this->privacyBody(),
            ],
            [
                'slug'  => 'terms',
                'title' => 'Terms & Conditions',
                'body'  => $this->termsBody(),
            ],
            [
                'slug'  => 'faq',
                'title' => 'Frequently Asked Questions',
                'body'  => '<p>Browse common questions on our <a href="/contact">contact page</a> or reach out at <a href="mailto:support@cstees.com">support@cstees.com</a>.</p>',
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'title'            => $p['title'],
                    'body'             => $p['body'],
                    'meta_title'       => $p['title'] . ' | cstees',
                    'meta_description' => 'Read our ' . $p['title'] . ' page on cstees.',
                    'is_active'        => true,
                ]
            );
        }

        $this->command->info('Pages seeded (' . count($pages) . ').');
    }

    protected function aboutBody(): string
    {
        return <<<HTML
<p>cstees is a Kolkata-based studio building style-led graphic essentials for everyday wear. Every piece is designed in-house, manufactured with care, and shipped across India.</p>
<h3>Our promise</h3>
<ul>
    <li>Premium-feel fabrics</li>
    <li>Curated drops, not endless catalogue</li>
    <li>Honest pricing and clear support</li>
</ul>
<p>Questions? Email us at <a href="mailto:support@cstees.com">support@cstees.com</a>.</p>
HTML;
    }

    protected function shippingBody(): string
    {
        return <<<HTML
<h3>Standard delivery</h3>
<p>We dispatch orders within 24–48 hours. Standard delivery across India takes 3–5 business days. You'll receive a tracking link as soon as your order ships.</p>
<h3>Free shipping</h3>
<p>Orders above ₹999 ship free. Below that, a flat ₹79 delivery charge applies at checkout.</p>
<h3>Cash on Delivery</h3>
<p>COD is available for orders under ₹3,000 across most pin codes in India.</p>
HTML;
    }

    protected function returnsBody(): string
    {
        return <<<HTML
<h3>30-day returns</h3>
<p>Not loving your fit? You have 30 days from delivery to request a return or exchange. Items should be unworn, unwashed, and with original tags.</p>
<h3>How to start a return</h3>
<ol>
    <li>Sign in to your account and open the relevant order.</li>
    <li>Click <strong>Cancel Order</strong> if it hasn't shipped, or contact us for a return label.</li>
    <li>Drop the package at your nearest courier point.</li>
</ol>
<p>Refunds are processed within 5 business days of receiving the return.</p>
HTML;
    }

    protected function privacyBody(): string
    {
        return <<<HTML
<h3>What we collect</h3>
<p>We collect only what's needed to process your orders and provide support: name, email, phone, shipping address, and order history.</p>
<h3>How we use it</h3>
<p>Your data is used to fulfill orders, send shipping updates, and reply to support questions. We never sell your information.</p>
<h3>Cookies</h3>
<p>We use cookies to keep your cart and login session active and to measure aggregate site usage.</p>
<p>For privacy questions, email <a href="mailto:privacy@cstees.com">privacy@cstees.com</a>.</p>
HTML;
    }

    protected function termsBody(): string
    {
        return <<<HTML
<h3>Use of the site</h3>
<p>By using cstees.com you agree to use the site for personal, non-commercial shopping and not to attempt to interfere with our systems.</p>
<h3>Pricing & availability</h3>
<p>All prices are in Indian Rupees (₹) and inclusive of applicable taxes unless otherwise noted. We may correct pricing errors before an order ships.</p>
<h3>Intellectual property</h3>
<p>All graphics, photography, and copy on this site are the property of cstees and may not be reproduced without permission.</p>
HTML;
    }
}
