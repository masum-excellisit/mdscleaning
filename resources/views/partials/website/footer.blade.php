<footer class="site-footer">
  <div class="container-xxl">
    <div class="row g-5 footer-main">
      <div class="col-lg-4">
        <img class="footer-logo" src="{{ asset('assets/images/logo-mds.png') }}" alt="{{ setting('site_name', 'MDS Cleaning') }} logo">
        <p class="footer-copy mb-0">
          {{ setting('footer_tagline', 'MDS Cleaning, LLC strives to satisfy each client with great customer service. Trustworthy and meticulous in providing efficient quality services.') }}
        </p>
      </div>
      <div class="col-lg-4">
        <h3 class="footer-title">Head Office</h3>
        <p class="footer-copy">{{ setting('address', 'MDS Cleaning, Carrollton, TX 75010') }}</p>
        <div class="footer-divider"></div>
        <p class="footer-copy mb-0">
          @if(setting('phone'))
          <a href="tel:{{ setting('phone') }}">{{ setting('phone') }}</a><br>
          @endif
          @if(setting('email'))
          <a href="mailto:{{ setting('email') }}">{{ setting('email') }}</a>
          @endif
        </p>
      </div>
      <div class="col-lg-4">
        <h3 class="footer-title">Operating Hours</h3>
        <p class="footer-copy mb-0">
          {!! nl2br(e(setting('business_hours', "Mon - Fri: 8am - 8pm\nSaturday: 9am - 7pm\nSunday: 9am - 8pm"))) !!}
        </p>
      </div>
    </div>

    <div class="footer-bottom">
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
</footer>
