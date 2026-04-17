<footer class="site-footer">
    <div class="main-container">
        <div class="footer-grid">

            <div class="footer-brand-block">
                <a class="footer-logo" href="{{ route('home') }}" aria-label="{{ setting('site_name', 'cstees') }}">
                    <span class="brand-lockup brand-lockup-footer">
                        <img class="brand-shirt" src="{{ asset('assets/extracted/shirt-mark.png') }}" alt="">
                        <span class="brand-word">{{ setting('site_name', 'cstees') }}</span>
                    </span>
                </a>
                <p>{{ setting('site_tagline', 'Premium graphic essentials designed in-house for effortless everyday wear.') }}</p>
                <div class="social-links">
                    @if($u = setting('facebook_url'))<a href="{{ $u }}" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>@endif
                    @if($u = setting('instagram_url'))<a href="{{ $u }}" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>@endif
                    @if($u = setting('twitter_url'))<a href="{{ $u }}" target="_blank" aria-label="Twitter"><i class="bi bi-twitter"></i></a>@endif
                    @if($u = setting('youtube_url'))<a href="{{ $u }}" target="_blank" aria-label="YouTube"><i class="bi bi-youtube"></i></a>@endif
                    @if($u = setting('pinterest_url'))<a href="{{ $u }}" target="_blank" aria-label="Pinterest"><i class="bi bi-pinterest"></i></a>@endif
                </div>
                <div class="download-app">
                    <h3>Download The App</h3>
                    <div class="store-badges">
                        <a class="store-badge" href="#"><i class="bi bi-google-play"></i><span><small>android app on</small><strong>Google Play</strong></span></a>
                        <a class="store-badge" href="#"><i class="bi bi-apple"></i><span><small>Available on the</small><strong>App Store</strong></span></a>
                    </div>
                </div>
            </div>

            <div class="footer-link-block">
                <h4>Need Help</h4>
                <ul>
                    <li><a href="{{ route('contact.index') }}">Contact Us</a></li>
                    <li><a href="{{ route('account.orders') }}">Track Order</a></li>
                    <li><a href="{{ route('pages.show', 'returns') }}">Returns &amp; Refunds</a></li>
                    <li><a href="{{ route('pages.show', 'faq') }}">FAQ's</a></li>
                    <li><a href="{{ route('pages.show', 'careers') }}">Career</a></li>
                </ul>
            </div>

            <div class="footer-link-block">
                <h4>Company</h4>
                <ul>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('collections.index') }}">Our Collections</a></li>
                    <li><a href="{{ route('blog.index') }}">Style Journal</a></li>
                    <li><a href="{{ route('contact.index') }}">Support</a></li>
                </ul>
            </div>

            <div class="footer-link-block">
                <h4>More Info</h4>
                <ul>
                    <li><a href="{{ route('pages.show', 'terms') }}">Term and Conditions</a></li>
                    <li><a href="{{ route('pages.show', 'privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('pages.show', 'shipping-policy') }}">Shipping Policy</a></li>
                    <li><a href="{{ route('pages.show', 'sitemap') }}">Sitemap</a></li>
                </ul>
            </div>

            <div class="footer-contact-block">
                <h4>Support</h4>
                <div class="contact-copy">
                    @if($email = setting('site_email', 'support@cstees.com'))
                        <p><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                    @endif
                </div>
                <div class="newsletter-box">
                    <h3>Our Newsletter</h3>
                    <form class="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <input type="email" name="email" placeholder="Enter your email" aria-label="Email address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="footer-bottom">Copyright &copy; {{ date('Y') }} {{ setting('site_name', 'cstees') }}. All rights reserved.</div>
    </div>
</footer>
