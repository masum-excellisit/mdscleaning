<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            [$sizeMap, $colorMap] = $this->seedAttributes();
            $this->seedProducts($sizeMap, $colorMap);
        });
    }

    /** @return array{0: array<string,int>, 1: array<string,int>} */
    protected function seedAttributes(): array
    {
        // Size attribute
        $size = Attribute::firstOrCreate(['name' => 'Size'], ['type' => 'size']);
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $sizeMap = [];
        foreach ($sizes as $s) {
            $sizeMap[$s] = AttributeValue::firstOrCreate(
                ['attribute_id' => $size->id, 'value' => $s]
            )->id;
        }

        // Color attribute
        $color = Attribute::firstOrCreate(['name' => 'Color'], ['type' => 'color']);
        $colors = [
            'Cream'  => '#f2e3cd',
            'Honey'  => '#d8b257',
            'Mocha'  => '#8c6c57',
            'White'  => '#ffffff',
            'Black'  => '#16324a',
            'Sky'    => '#79afe3',
            'Blush'  => '#d15378',
        ];
        $colorMap = [];
        foreach ($colors as $name => $code) {
            $colorMap[$name] = AttributeValue::firstOrCreate(
                ['attribute_id' => $color->id, 'value' => $name],
                ['color_code'   => $code]
            )->id;
        }

        return [$sizeMap, $colorMap];
    }

    protected function seedProducts(array $sizeMap, array $colorMap): void
    {
        $cats = Category::pluck('id', 'slug');
        $cols = Collection::pluck('id', 'slug');

        // 20 products. Each row: [name, category_slug, collection_slug, price, compare_price, image, flags, with_variants, sizes, colors]
        $rows = [
            ['Studio Long Sleeve',   'long-sleeves', 'signature-graphics',     1499, 1899, 'image-17.png', ['featured','best_seller'],     true,  ['S','M','L','XL'],     ['Cream','Mocha']],
            ['Horizon Script Tee',   't-shirts',     'signature-graphics',     899,  1199, 'image-16.png', ['best_seller'],                true,  ['S','M','L','XL'],     ['White','Sky','Black']],
            ['Signature Graphic Tee','t-shirts',     'signature-graphics',     999,  1299, 'image-19.png', ['featured','best_seller'],     true,  ['S','M','L','XL','XXL'], ['Black','Sky','Blush']],
            ['Weekend Relaxed Tee',  't-shirts',     'weekend-icons',          799,  999,  'image-15.png', ['new_arrival'],                true,  ['M','L','XL'],         ['Cream','Honey']],
            ['Coastal Print Tee',    't-shirts',     'new-arrivals',           849,  1099, 'image-13.png', ['new_arrival'],                true,  ['S','M','L','XL'],     ['Mocha','Cream','White']],
            ['Softline Script Tee',  't-shirts',     'soft-everyday-layers',   849,  null, 'image-14.png', ['new_arrival'],                true,  ['XS','S','M','L'],     ['Sky','White']],
            ['Midnight Outline Tee', 't-shirts',     'signature-graphics',     899,  1199, 'image-12.png', [],                             true,  ['S','M','L'],          ['Black','Mocha']],
            ['Elevated Message Tee', 't-shirts',     'weekend-icons',          949,  1199, 'image-11.png', ['featured'],                   true,  ['S','M','L','XL'],     ['Black','Honey']],
            ['Soft Cotton Crew',     't-shirts',     'soft-everyday-layers',   699,  null, 'image-18.png', [],                             true,  ['S','M','L','XL'],     ['Cream','White','Sky']],
            ['Sun-Faded Pocket Tee', 't-shirts',     'soft-everyday-layers',   799,  999,  'image-09.png', ['best_seller'],                true,  ['M','L','XL'],         ['Honey','Mocha']],
            ['Easy Layer Henley',    'henleys',      'soft-everyday-layers',   1199, 1499, 'image-07.png', ['featured'],                   true,  ['S','M','L','XL'],     ['Cream','Mocha']],
            ['Garden Print Polo',    'polos',        'gift-ready-picks',       1099, 1399, 'image-02.png', [],                             true,  ['S','M','L'],          ['White','Sky']],
            ['Brand Mark Long Tee',  'long-sleeves', 'signature-graphics',     1299, null, 'image-17.png', [],                             true,  ['S','M','L'],          ['White','Black']],
            ['Color Block Sleeve',   'long-sleeves', 'weekend-icons',          1399, 1699, 'image-16.png', ['new_arrival'],                true,  ['M','L','XL'],         ['Sky','Blush']],
            ['Coastal Drape Top',    't-shirts',     'new-arrivals',           949,  1199, 'image-19.png', ['new_arrival'],                false, [],                      []],
            ['Slow Wash Tee',        't-shirts',     'soft-everyday-layers',   849,  null, 'image-15.png', [],                             false, [],                      []],
            ['Studio Hoodie',        'hoodies',      'signature-graphics',     1899, 2299, 'image-13.png', ['featured','best_seller'],     true,  ['M','L','XL','XXL'],   ['Black','Cream','Mocha']],
            ['Boxy Crop Tee',        'crops',        'gift-ready-picks',       699,  899,  'image-14.png', ['new_arrival'],                true,  ['XS','S','M'],         ['Cream','Blush']],
            ['Type Specimen Tee',    't-shirts',     'signature-graphics',     899,  1099, 'image-12.png', [],                             true,  ['S','M','L','XL'],     ['White','Black']],
            ['Vintage Wash Tee',     't-shirts',     'weekend-icons',          749,  null, 'image-11.png', ['best_seller'],                false, [],                      []],
        ];

        foreach ($rows as $i => $r) {
            [$name, $catSlug, $colSlug, $price, $compare, $image, $flags, $withVariants, $sizes, $colors] = $r;

            $product = Product::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name'              => $name,
                    'sku'               => 'CST-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                    'category_id'       => $cats[$catSlug] ?? $cats->first(),
                    'collection_id'     => $cols[$colSlug] ?? null,
                    'price'             => $price,
                    'compare_price'     => $compare,
                    'cost_price'        => round($price * 0.55, 2),
                    'weight'            => rand(180, 380),
                    'short_description' => $this->shortDescription($name),
                    'description'       => $this->longDescription($name),
                    'is_active'         => true,
                    'is_featured'       => in_array('featured', $flags),
                    'is_best_seller'    => in_array('best_seller', $flags),
                    'is_new_arrival'    => in_array('new_arrival', $flags),
                    'allow_reviews'     => true,
                    'meta_title'        => $name . ' | cstees',
                    'meta_description'  => $this->shortDescription($name),
                ]
            );

            // Image
            ProductImage::firstOrCreate(
                ['product_id' => $product->id, 'image_path' => "assets/extracted/{$image}"],
                ['alt_text' => $name, 'sort_order' => 1, 'is_primary' => true]
            );

            // Add a couple of secondary images by rotating through the asset set
            $extras = ['image-13.png', 'image-14.png', 'image-15.png', 'image-11.png'];
            foreach (array_slice($extras, 0, 2) as $j => $extra) {
                if ($extra === $image) continue;
                ProductImage::firstOrCreate(
                    ['product_id' => $product->id, 'image_path' => "assets/extracted/{$extra}"],
                    ['alt_text' => $name . ' alternate', 'sort_order' => $j + 2, 'is_primary' => false]
                );
            }

            // Variants + inventory
            if ($withVariants && ! empty($sizes) && ! empty($colors)) {
                foreach ($sizes as $s) {
                    foreach ($colors as $c) {
                        $variant = ProductVariant::updateOrCreate(
                            ['sku' => $product->sku . '-' . $s . '-' . strtoupper(substr($c, 0, 3))],
                            [
                                'product_id'    => $product->id,
                                'price'         => null,
                                'compare_price' => null,
                                'stock'         => rand(8, 35),
                                'is_active'     => true,
                            ]
                        );

                        $variant->attributeValues()->syncWithoutDetaching([
                            $sizeMap[$s], $colorMap[$c],
                        ]);

                        Inventory::updateOrCreate(
                            ['product_id' => $product->id, 'variant_id' => $variant->id],
                            ['qty' => $variant->stock, 'low_stock_threshold' => 10]
                        );
                    }
                }
            } else {
                Inventory::updateOrCreate(
                    ['product_id' => $product->id, 'variant_id' => null],
                    ['qty' => rand(20, 80), 'low_stock_threshold' => 10]
                );
            }
        }

        $this->command->info('Products seeded (' . count($rows) . ') with attributes, variants, and inventory.');
    }

    protected function shortDescription(string $name): string
    {
        return "{$name} — soft-touch cotton, easy daily fit, and the cstees in-house graphic feel.";
    }

    protected function longDescription(string $name): string
    {
        return <<<HTML
<p>The <strong>{$name}</strong> is part of our in-house cstees catalogue, designed in Kolkata and built around premium-feel fabric, a clean fit, and a confident graphic point of view.</p>
<ul>
    <li>100% premium cotton with soft-touch comfort</li>
    <li>Easy regular fit designed for daily wear and easy layering</li>
    <li>In-house graphic, finished with care</li>
    <li>Machine wash cold; tumble dry low</li>
</ul>
<p>Pair it with denim, joggers, or our signature crop layer to complete the look.</p>
HTML;
    }
}
