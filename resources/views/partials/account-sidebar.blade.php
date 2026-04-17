{{-- Reusable account sidebar. Highlights based on current route. --}}
<aside class="account-sidebar">
    <div class="account-nav-list">
        <a class="account-nav-link {{ active_class('account.dashboard') }}" href="{{ route('account.dashboard') }}">
            <i class="bi bi-grid"></i> Overview
        </a>
        <a class="account-nav-link {{ active_class(['account.orders', 'account.orders.show']) }}" href="{{ route('account.orders') }}">
            <i class="bi bi-receipt"></i> Orders
        </a>
        <a class="account-nav-link {{ active_class('wishlist.*') }}" href="{{ route('wishlist.index') }}">
            <i class="bi bi-heart"></i> Wishlist
        </a>
        <a class="account-nav-link {{ active_class('account.addresses') }}" href="{{ route('account.addresses') }}">
            <i class="bi bi-geo-alt"></i> Addresses
        </a>
        <a class="account-nav-link {{ active_class('account.profile') }}" href="{{ route('account.profile') }}">
            <i class="bi bi-person"></i> Profile
        </a>
        <a class="account-nav-link" href="{{ route('contact.index') }}">
            <i class="bi bi-headset"></i> Support
        </a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="account-nav-link" style="background:none; border:0; cursor:pointer; width:100%; text-align:left;">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</aside>
