<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title'       => 'Premium cstees staples designed for everyday expression.',
                'subtitle'    => 'Discover our in-house graphic tees, elevated basics, and easy layering pieces in a calm, baby-blue shopping experience.',
                'button_text' => 'Shop The Drop',
                'button_url'  => '/shop',
                'image'       => 'assets/extracted/image-17.png',
                'page'        => 'home',
                'sort_order'  => 1,
            ],
            [
                'title'       => 'Signature graphics, soft layers, weekend icons.',
                'subtitle'    => 'Three core capsules built around one clear cstees point of view.',
                'button_text' => 'Browse Collections',
                'button_url'  => '/collections',
                'image'       => 'assets/extracted/image-19.png',
                'page'        => 'home',
                'sort_order'  => 2,
            ],
            [
                'title'       => 'Free shipping on orders above ₹999.',
                'subtitle'    => 'Get your favourites delivered with care, anywhere in India.',
                'button_text' => 'Shop Now',
                'button_url'  => '/shop',
                'image'       => 'assets/extracted/image-15.png',
                'page'        => 'home',
                'sort_order'  => 3,
            ],
        ];

        foreach ($banners as $row) {
            Banner::updateOrCreate(
                ['title' => $row['title']],
                array_merge($row, ['is_active' => true])
            );
        }

        $this->command->info('Banners seeded (' . count($banners) . ').');
    }
}
