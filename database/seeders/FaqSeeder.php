<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['How fast do you ship?',                            'Most orders are dispatched within 24–48 hours. Standard delivery across India takes 3–5 business days, with tracking shared as soon as your order ships.'],
            ['Do you ship across India?',                        'Yes — we ship to all serviceable PIN codes in India. International shipping is not currently available.'],
            ['Is Cash on Delivery available?',                   'COD is available for orders under ₹3,000 across most PIN codes in India. You can choose COD at checkout.'],
            ['What is your return policy?',                      'You can return or exchange items within 30 days of delivery as long as they are unworn, unwashed, and have original tags.'],
            ['How do I check my order status?',                  'Log into your account and open <strong>My Orders</strong> to see status updates and tracking information for every order you placed.'],
            ['Can I edit my order after placing it?',            'If your order has not yet been packed, our support team can usually update size or address details. Contact us early — within an hour of placing the order is best.'],
            ['How do I use a coupon code?',                      'Enter your coupon code in the cart page (just below the order summary) and click Apply. Discounts will be reflected in the totals immediately.'],
            ['What sizes do you offer?',                         'Our standard size run is XS to XXL. Each product page lists the exact sizes available for that style — out-of-stock sizes are disabled automatically.'],
            ['Are your products true to size?',                  'Most of our tees and crews are designed for a regular fit. Crops run boxy. If unsure, size up by one for a relaxed look.'],
            ['How can I contact customer support?',              'Email us at <a href="mailto:support@cstees.com">support@cstees.com</a> or use the form on the <a href="/contact">contact page</a>. We reply within 24 hours, Mon–Sat.'],
        ];

        foreach ($faqs as $i => [$q, $a]) {
            Faq::updateOrCreate(
                ['question' => $q],
                [
                    'answer'     => $a,
                    'sort_order' => $i + 1,
                    'is_active'  => true,
                ]
            );
        }

        $this->command->info('FAQs seeded (' . count($faqs) . ').');
    }
}
