<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'T-Shirts',     'description' => 'Our core graphic tees and everyday essentials.'],
            ['name' => 'Long Sleeves', 'description' => 'Layered comfort for in-between days.'],
            ['name' => 'Hoodies',      'description' => 'Cozy fits with the brand-mark feel.'],
            ['name' => 'Polos',        'description' => 'Polished basics for relaxed wear.'],
            ['name' => 'Crops',        'description' => 'Boxy cuts for confident styling.'],
            ['name' => 'Henleys',      'description' => 'Classic button-front silhouettes.'],
            ['name' => 'Sweatshirts',  'description' => 'Soft heavyweights for evenings out.'],
            ['name' => 'Accessories',  'description' => 'Caps, totes, and finishing pieces.'],
        ];

        foreach ($categories as $i => $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name'        => $cat['name'],
                    'description' => $cat['description'],
                    'image'       => null,
                    'sort_order'  => $i + 1,
                    'is_active'   => true,
                ]
            );
        }

        $this->command->info('Categories seeded (' . count($categories) . ').');
    }
}
