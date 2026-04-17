@if(setting('topbar_is_active', '1'))
<div class="topbar">
    <div class="main-container">
        <div class="topbar-inner">
            <div class="topbar-meta">
                <i class="bi bi-headset"></i>
                <span>Need Support :
                    @if($phone = setting('site_phone', '(444 666 999)'))
                        <a href="tel:{{ preg_replace('/\D/', '', $phone) }}">{{ $phone }}</a>
                    @endif
                </span>
            </div>
            <form class="search-wrap topbar-search" role="search" action="{{ route('shop') }}" method="GET">
                <i class="bi bi-search"></i>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products, collections, blogs..." aria-label="Search products">
            </form>
            @auth
                <a class="login-btn" href="{{ route('account.dashboard') }}">{{ Str::limit(auth()->user()->name, 14) }}</a>
            @else
                <a class="login-btn" href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </div>
</div>
@endif
