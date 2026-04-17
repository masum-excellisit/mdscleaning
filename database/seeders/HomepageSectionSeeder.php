<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use Illuminate\Database\Seeder;

class HomepageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['hero_slider',        'Premium cstees staples designed for everyday expression.', 'Discover our in-house graphic tees, elevated basics, and easy layering pieces in a calm, baby-blue shopping experience.', null],
            ['service_highlights', 'Why shop cstees',                                          'In-house graphics, premium cotton feel, fast dispatch, easy returns.',                                                  null],
            ['best_sellers',       'Signature Best Sellers',                                   'Our top-performing cstees essentials with clean fits, bold graphics, and easy repeat-wear appeal.',                  null],
            ['collection_promos',  'Curated cstees edits for every mood',                      'Explore the in-house collections our customers move through most, from soft everyday layers to standout graphic statements.', null],
            ['new_arrivals',       'New In From cstees',                                       'The latest additions to our brand catalogue, styled for a calmer and more intentional shopping flow.',              null],
            ['brand_note',         'Wear the Story',                                           'Inside cstees',                                                                                                       'cstees started in Kolkata with a simple idea: make statement fashion feel premium, accessible, and easy to shop. Every drop is designed in-house, art-directed end to end, and built around a confident baby-blue brand world.'],
            ['latest_blogs',       'From the Journal',                                         'Style notes, lookbooks, and brand stories from the cstees team.',                                                       null],
            ['newsletter',         'Stay in the Loop',                                         'Subscribe for new drops, special offers, and styling notes — straight to your inbox.',                                  null],
        ];

        foreach ($sections as $i => [$key, $title, $subtitle, $content]) {
            HomepageSection::updateOrCreate(
                ['section_key' => $key],
                [
                    'title'      => $title,
                    'subtitle'   => $subtitle,
                    'content'    => $content,
                    'is_active'  => true,
                    'sort_order' => $i + 1,
                    'settings'   => null,
                ]
            );
        }

        $this->command->info('Homepage sections seeded (' . count($sections) . ').');
    }
}
