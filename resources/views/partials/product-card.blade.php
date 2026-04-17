{{-- Reusable product card. Expects $product (App\Models\Product). --}}
@php
    $imgUrl  = $product->primaryImage?->url ?? asset('assets/extracted/image-13.png');
    $stock   = $product->total_stock;
    $isWish  = auth()->check() ? auth()->user()->wishlists()->where('product_id', $product->id)->exists() : false;
    $discount = $product->discount_percent;

    if ($product->is_new_arrival) {
        $badgeText = 'New';
    } elseif ($product->is_best_seller) {
        $badgeText = 'Hot';
    } elseif ($discount) {
        $badgeText = $discount . '% Off';
    } elseif ($product->compare_price && $product->compare_price > $product->price) {
        $badgeText = 'Sale';
    } else {
        $badgeText = null;
    }
@endphp

<article class="product-card">
    @if($badgeText)
        <span class="product-badge">{{ $badgeText }}</span>
    @endif

    <a class="wishlist-btn js-wishlist {{ $isWish ? 'is-active' : '' }}"
       href="{{ route('wishlist.index') }}"
       data-product-id="{{ $product->id }}"
       data-url="{{ route('wishlist.toggle') }}"
       aria-label="Add {{ $product->name }} to wishlist">
        <i class="bi {{ $isWish ? 'bi-heart-fill' : 'bi-heart' }}"></i>
    </a>

    <div class="product-image">
        <a href="{{ route('product.show', $product->slug) }}">
            <img src="{{ $imgUrl }}" alt="{{ $product->name }}" loading="lazy">
        </a>
    </div>

    <div class="product-body">
        <h3><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>

        <div class="rating-row">
            <div class="stars">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-half"></i>
            </div>
            <span>(0)</span>
        </div>

        <div class="price-row">
            <div class="price-info">
                <span class="current-price">{{ format_price($product->price) }}</span>
                @if($product->compare_price && $product->compare_price > $product->price)
                    <span class="old-price">{{ format_price($product->compare_price) }}</span>
                @endif
                @if($discount)
                    <span class="discount-text">{{ $discount }}% off</span>
                @endif
            </div>
            @if($stock > 0)
                <span class="availability">Available {{ $stock }}</span>
            @else
                <span class="availability">Out of stock</span>
            @endif
        </div>

        <div class="product-actions">
            <a class="buy-btn" href="{{ route('product.show', $product->slug) }}">View Product</a>
            <form class="d-inline js-add-to-cart" action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="qty" value="1">
                <button class="cart-btn" type="submit" aria-label="Add {{ $product->name }} to cart">
                    <i class="bi bi-bag"></i>
                </button>
            </form>
        </div>
    </div>
</article>
