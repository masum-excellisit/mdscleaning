<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Categories first
        $categories = ['Style Guide', 'Brand Notes', 'Lookbook', 'Merchandising'];
        $catMap = [];
        foreach ($categories as $name) {
            $catMap[$name] = BlogCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            )->id;
        }

        // Pick the admin user as default author
        $author = User::where('email', 'admin@cstees.com')->first() ?? User::first();
        $authorId = $author?->id;

        $posts = [
            [
                'title'    => 'How to build a seasonal graphic-tee rotation without overbuying',
                'category' => 'Style Guide',
                'image'    => 'assets/extracted/image-18.png',
                'excerpt'  => 'Use collection-led shopping, layered neutrals, and one standout print per look to keep a wardrobe feeling both intentional and wearable.',
                'body'     => $this->bodyFor('rotation'),
                'days_ago' => 5,
            ],
            [
                'title'    => 'What makes a homepage convert better for fashion',
                'category' => 'Brand Notes',
                'image'    => 'assets/extracted/image-02.png',
                'excerpt'  => 'Hero hierarchy, clear pricing, and repeatable product cards keep users moving deeper into the store.',
                'body'     => $this->bodyFor('homepage'),
                'days_ago' => 14,
            ],
            [
                'title'    => 'Three hero-banner layouts that balance copy and product art',
                'category' => 'Lookbook',
                'image'    => 'assets/extracted/image-07.png',
                'excerpt'  => 'Good promotional design helps the offer speak without overwhelming the product image.',
                'body'     => $this->bodyFor('hero-layouts'),
                'days_ago' => 28,
            ],
        ];

        foreach ($posts as $p) {
            $publishedAt = now()->subDays($p['days_ago']);
            Blog::updateOrCreate(
                ['slug' => Str::slug($p['title'])],
                [
                    'title'            => $p['title'],
                    'excerpt'          => $p['excerpt'],
                    'body'             => $p['body'],
                    'image'            => $p['image'],
                    'author_id'        => $authorId,
                    'blog_category_id' => $catMap[$p['category']] ?? null,
                    'is_published'     => true,
                    'published_at'     => $publishedAt,
                    'meta_title'       => $p['title'] . ' | cstees',
                    'meta_description' => $p['excerpt'],
                    'created_at'       => $publishedAt,
                    'updated_at'       => $publishedAt,
                ]
            );
        }

        $this->command->info('Blog seeded: ' . count($categories) . ' categories, ' . count($posts) . ' posts.');
    }

    protected function bodyFor(string $key): string
    {
        return match ($key) {
            'rotation' => <<<HTML
<p>Building a smart graphic-tee rotation isn't about owning more pieces — it's about owning the right ones together.</p>
<h3>Start with three anchor pieces</h3>
<p>Pick one statement print, one elevated neutral, and one easy daily wear. From those three you can build full looks for casual weekends, work-from-home days, and evening plans without rebuying.</p>
<h3>Layer up with soft basics</h3>
<p>A sun-faded pocket tee, a long-sleeve crew, or a relaxed henley quietly extend every standout print into colder months and over-air-conditioned afternoons.</p>
<h3>Refresh once per season</h3>
<p>One new drop every 6–8 weeks keeps the rotation moving without crowding the wardrobe. Watch the New Arrivals collection for cstees pieces that pair with what you already love.</p>
HTML,
            'homepage' => <<<HTML
<p>The fashion homepage has one job: get the right shopper to the right product, fast.</p>
<h3>Hero with intention</h3>
<p>Lead with a single offer. A strong baby-blue hero with one clear button outperforms three competing CTAs almost every time.</p>
<h3>Repeatable product cards</h3>
<p>Use the same product card pattern across home, shop, search, and related sections. Familiarity reduces decision friction.</p>
<h3>Trust strips that load instantly</h3>
<p>Free shipping above ₹999, easy returns, and 24/7 support — these aren't decoration, they're conversion levers.</p>
HTML,
            'hero-layouts' => <<<HTML
<p>Promotional hero design walks a line: too much copy and the offer gets lost; too much product and the message disappears.</p>
<h3>Layout 1 — Copy left, product right</h3>
<p>Classic for clarity. The headline carries the offer, the product sits as proof.</p>
<h3>Layout 2 — Centered statement</h3>
<p>Best for brand-led seasonal launches where the mood matters more than a specific SKU.</p>
<h3>Layout 3 — Stacked split</h3>
<p>Use on mobile-heavy traffic. Stack the headline above the product art and let the eye move down naturally.</p>
HTML,
            default => '<p>Content coming soon.</p>',
        };
    }
}
