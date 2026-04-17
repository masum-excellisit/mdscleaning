<header class="site-header">
    <div class="main-container">
        <div class="header-top">
            <a class="brand-logo" href="{{ route('home') }}" aria-label="{{ setting('site_name', 'cstees') }}">
                <span class="brand-lockup">
                    @if($logo = setting('logo'))
                        <img class="brand-shirt" src="{{ asset($logo) }}" alt="">
                    @else
                        <img class="brand-shirt" src="{{ asset('assets/extracted/shirt-mark.png') }}" alt="">
                    @endif
                    <span class="brand-word">{{ setting('site_name', 'cstees') }}</span>
                </span>
            </a>
            <div class="header-brand-nav">
                <nav class="nav-row" aria-label="Primary">
                    <ul class="nav-list">
                        <li><a href="{{ route('home') }}" class="{{ active_class('home') }}">Home</a></li>
                        <li><a href="{{ route('shop') }}" class="{{ active_class(['shop', 'product.show']) }}">Shop</a></li>
                        <li><a href="{{ route('collections.index') }}" class="{{ active_class('collections.*') }}">Our Collections</a></li>
                        <li><a href="{{ route('about') }}" class="{{ active_class('about') }}">About Us</a></li>
                        <li><a href="{{ route('blog.index') }}" class="{{ active_class('blog.*') }}">Blog</a></li>
                        <li><a href="{{ route('contact.index') }}" class="{{ active_class('contact.*') }}">Contact</a></li>
                    </ul>
                </nav>
                <div class="header-actions">
                    <a class="action-box" href="{{ route('wishlist.index') }}" aria-label="Wishlist">
                        <i class="bi bi-heart"></i>
                        @if(($wc = wishlist_count()) > 0)<span class="action-badge">{{ $wc }}</span>@endif
                    </a>
                    <a class="action-box" href="@auth{{ route('account.dashboard') }}@else{{ route('login') }}@endauth" aria-label="Profile"><i class="bi bi-person"></i></a>
                    <a class="action-box" href="{{ route('cart.index') }}" aria-label="Cart">
                        <i class="bi bi-cart3"></i>
                        @if(($cc = cart_count()) > 0)<span class="action-badge">{{ $cc }}</span>@endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
