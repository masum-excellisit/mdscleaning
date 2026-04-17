<div class="top-strip">
  <div class="container-xxl">
    <div class="top-strip__inner">
      <p class="top-strip__announcement mb-0">
        {{ setting('announcement_text', 'Accepting Commercial Cleaning Contracts from small to medium sized properties') }}
      </p>
      <div class="top-strip__links">
        @if(setting('whatsapp'))
        <a href="https://wa.me/{{ setting('whatsapp') }}" target="_blank" rel="noreferrer">
          <i class="bi bi-whatsapp" aria-hidden="true"></i>
          <span>Whatsapp</span>
        </a>
        @endif
        @if(setting('facebook_url'))
        <a href="{{ setting('facebook_url') }}" target="_blank" rel="noreferrer" aria-label="Facebook">
          <i class="bi bi-facebook" aria-hidden="true"></i>
          <span>Facebook</span>
        </a>
        @endif
        @if(setting('instagram_url'))
        <a href="{{ setting('instagram_url') }}" target="_blank" rel="noreferrer" aria-label="Instagram">
          <i class="bi bi-instagram" aria-hidden="true"></i>
          <span>Instagram</span>
        </a>
        @endif
        @if(setting('phone'))
        <a class="phone-link" href="tel:{{ setting('phone') }}">
          <i class="bi bi-telephone-fill" aria-hidden="true"></i>
          <span>{{ setting('phone') }}</span>
        </a>
        @endif
      </div>
    </div>
  </div>
</div>
