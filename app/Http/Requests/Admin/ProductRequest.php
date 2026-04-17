<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $productId = $this->route('id');

        return [
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($productId)],
            'sku'               => ['required', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($productId)],
            'category_id'       => ['required', 'integer', 'exists:categories,id'],
            'collection_id'     => ['nullable', 'integer', 'exists:collections,id'],
            'price'             => ['required', 'numeric', 'min:0'],
            'compare_price'     => ['nullable', 'numeric', 'min:0', 'gte:price'],
            'cost_price'        => ['nullable', 'numeric', 'min:0'],
            'weight'            => ['nullable', 'numeric', 'min:0'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],

            // Flags
            'is_active'         => ['nullable', 'boolean'],
            'is_featured'       => ['nullable', 'boolean'],
            'is_best_seller'    => ['nullable', 'boolean'],
            'is_new_arrival'    => ['nullable', 'boolean'],
            'allow_reviews'     => ['nullable', 'boolean'],

            // SEO
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string', 'max:500'],

            // Images
            'images'            => ['nullable', 'array'],
            'images.*'          => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'primary_image'     => ['nullable', 'integer'],
            'remove_images'     => ['nullable', 'array'],
            'remove_images.*'   => ['integer', 'exists:product_images,id'],

            // Inventory (single-variant case)
            'stock'             => ['nullable', 'integer', 'min:0'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],

            // Variants
            'variants'                          => ['nullable', 'array'],
            'variants.*.id'                     => ['nullable', 'integer', 'exists:product_variants,id'],
            'variants.*.sku'                    => ['required_with:variants', 'string', 'max:100'],
            'variants.*.price'                  => ['nullable', 'numeric', 'min:0'],
            'variants.*.compare_price'          => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock'                  => ['nullable', 'integer', 'min:0'],
            'variants.*.is_active'              => ['nullable', 'boolean'],
            'variants.*.attribute_value_ids'    => ['nullable', 'array'],
            'variants.*.attribute_value_ids.*'  => ['integer', 'exists:attribute_values,id'],

            'remove_variants'                   => ['nullable', 'array'],
            'remove_variants.*'                 => ['integer', 'exists:product_variants,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'compare_price.gte' => 'Compare price must be greater than or equal to the price (it is the strikethrough original).',
            'images.*.max'      => 'Each image must be 4 MB or smaller.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'      => $this->boolean('is_active', true),
            'is_featured'    => $this->boolean('is_featured'),
            'is_best_seller' => $this->boolean('is_best_seller'),
            'is_new_arrival' => $this->boolean('is_new_arrival'),
            'allow_reviews'  => $this->boolean('allow_reviews', true),
        ]);
    }
}
