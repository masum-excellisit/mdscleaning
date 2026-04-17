<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        $collections = [
            [
                'name'        => 'Signature Graphics',
                'description' => 'The standout prints and statement pieces that define the cstees point of view.',
                'image'       => 'assets/extracted/image-18.png',
                'banner_image' => 'assets/extracted/image-18.png',
            ],
            [
                'name'        => 'Soft Everyday Layers',
                'description' => 'Relaxed silhouettes, easy tones, and premium basics designed for repeat wear.',
                'image'       => 'assets/extracted/image-09.png',
                'banner_image' => 'assets/extracted/image-09.png',
            ],
            [
                'name'        => 'Weekend Icons',
                'description' => 'Off-duty favorites with bold artwork, cleaner cuts, and dependable comfort.',
                'image'       => 'assets/extracted/image-07.png',
                'banner_image' => 'assets/extracted/image-07.png',
            ],
            [
                'name'        => 'Gift-Ready Picks',
                'description' => 'Easy-to-choose hero styles that make thoughtful gifting feel fast and polished.',
                'image'       => 'assets/extracted/image-02.png',
                'banner_image' => 'assets/extracted/image-02.png',
            ],
            [
                'name'        => 'New Arrivals',
                'description' => 'The latest additions to the cstees catalogue — fresh drops and seasonal capsules.',
                'image'       => 'assets/extracted/image-13.png',
                'banner_image' => 'assets/extracted/image-13.png',
            ],
        ];

        foreach ($collections as $i => $col) {
            Collection::updateOrCreate(
                ['slug' => Str::slug($col['name'])],
                [
                    'name'         => $col['name'],
                    'description'  => $col['description'],
                    'image'        => $col['image'],
                    'banner_image' => $col['banner_image'],
                    'sort_order'   => $i + 1,
                    'is_active'    => true,
                ]
            );
        }

        $this->command->info('Collections seeded (' . count($collections) . ').');
    }
}
