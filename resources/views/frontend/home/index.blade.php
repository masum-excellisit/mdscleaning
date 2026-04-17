@extends('layouts.website')

@section('meta_title', setting('site_name', 'MDS Cleaning') . ' | Professional Cleaning Services')

@section('content')
<main id="home">

  {{-- Hero Banner Slider --}}
  <section class="hero-section">
    <div id="homeBannerSlider" class="carousel slide carousel-fade hero-slider" data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="false" data-bs-wrap="true">

      @if($banners->count() > 1)
      <div class="carousel-indicators hero-slider__indicators">
        @foreach($banners as $i => $banner)
          <button type="button" data-bs-target="#homeBannerSlider" data-bs-slide-to="{{ $i }}"
                  class="{{ $i === 0 ? 'active' : '' }}" aria-label="Show banner {{ $i + 1 }}"></button>
        @endforeach
      </div>
      @endif

      <div class="carousel-inner">
        @forelse($banners as $i => $banner)
          <div class="carousel-item {{ $i === 0 ? 'active' : '' }}" data-bs-interval="3000">
            <div class="hero-slide">
              <img class="hero-slide__image" src="{{ $banner->image_url }}" alt="{{ $banner->title }}"
                   {{ $i === 0 ? 'loading=eager' : 'loading=lazy' }}>
              <div class="hero-slide__overlay"></div>
              <div class="container-xxl hero-section__container">
                <div class="hero-content">
                  @if($banner->subtitle)
                    <span class="hero-content__eyebrow">{{ $banner->subtitle }}</span>
                  @endif
                  <h1>{{ $banner->title }}</h1>
                  @if($banner->button_text && $banner->button_url)
                    <a class="btn btn-quote" href="{{ $banner->button_url }}">
                      <i class="bi bi-calendar3" aria-hidden="true"></i>
                      <span>{{ $banner->button_text }}</span>
                    </a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="carousel-item active">
            <div class="hero-slide">
              <img class="hero-slide__image" src="{{ asset('assets/images/hero-cleaning.jpg') }}"
                   alt="Professional cleaner preparing a bright home" loading="eager">
              <div class="hero-slide__overlay"></div>
              <div class="container-xxl hero-section__container">
                <div class="hero-content">
                  <span class="hero-content__eyebrow">Trusted Across DFW</span>
                  <h1>One Call Cleans It All</h1>
                  <a class="btn btn-quote" href="{{ route('contact.index') }}">
                    <i class="bi bi-calendar3" aria-hidden="true"></i>
                    <span>Get a Quote</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforelse
      </div>

      @if($banners->count() > 1)
      <button class="carousel-control-prev hero-slider__control" type="button"
              data-bs-target="#homeBannerSlider" data-bs-slide="prev" aria-label="Previous banner">
        <span class="hero-slider__control-icon" aria-hidden="true"><i class="bi bi-arrow-left"></i></span>
      </button>
      <button class="carousel-control-next hero-slider__control" type="button"
              data-bs-target="#homeBannerSlider" data-bs-slide="next" aria-label="Next banner">
        <span class="hero-slider__control-icon" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
      </button>
      @endif
    </div>
  </section>

  {{-- Why Choose Us --}}
  <section class="why-section" id="why">
    <div class="container-xxl">
      <h2 class="section-title section-title--left">{{ $whyChoose?->title ?? 'Why Choose Us?' }}</h2>
      <div class="row g-4">
        @php $whyItems = $whyChoose?->settings['items'] ?? [
          'Certified Professional Cleaners',
          'Environmentally Friendly Cleaning',
          'Bonded and Insured',
          'Available Evenings &amp; Weekends',
        ]; @endphp
        @foreach($whyItems as $idx => $item)
          <div class="col-sm-6 col-xl-3">
            <div class="why-card">
              <div class="why-card__number">{{ $idx + 1 }}</div>
              <p class="why-card__text mb-0">{!! $item !!}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Founder / Intro --}}
  <section class="founder-section">
    <div class="container-xxl">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <h2 class="section-title section-title--left">{{ $intro?->title ?? 'Meet Our Founder' }}</h2>
          <div class="founder-copy mb-0">
            {!! $intro?->content ?? '<p>Marquis Dawuane Simmons launched MDS Cleaning in July 2018. With nearly 10 years of cleaning experience, he is the owner and General Manager of MDS Cleaning, LLC. MDS Cleaning strives to satisfy each client with great customer service.</p>' !!}
          </div>
        </div>
        <div class="col-lg-5">
          @php $introImg = $intro?->settings['image'] ?? 'assets/images/founder.jpg'; @endphp
          <img class="founder-photo" src="{{ asset($introImg) }}" alt="Founder of MDS Cleaning">
        </div>
      </div>
    </div>
  </section>

  {{-- Services --}}
  <section class="services-section" id="services">
    <div class="container-xxl">
      <h2 class="section-title text-center">Our Services</h2>
      <div class="row g-4 justify-content-center">
        @forelse($services as $service)
          <div class="col-md-6 col-xl-4">
            <article class="service-card">
              <img src="{{ $service->image_url }}" alt="{{ $service->title }}">
              <h3 class="service-card__title mb-0">{{ $service->title }}</h3>
            </article>
          </div>
        @empty
          <p class="text-center text-muted">Services coming soon.</p>
        @endforelse
      </div>
    </div>
  </section>

  {{-- Testimonials --}}
  <section class="testimonials-section">
    <div class="container-xxl">
      <h2 class="section-title text-center">Hear From Our Clients</h2>
      <div class="row g-4">
        @forelse($testimonials as $t)
          <div class="col-lg-4">
            <article class="testimonial-card">
              <img class="testimonial-card__avatar" src="{{ $t->avatar_url }}" alt="{{ $t->name }}">
              <div class="testimonial-card__stars" aria-label="{{ $t->rating }} star review">
                @for($i = 1; $i <= 5; $i++)
                  <i class="bi bi-star{{ $i <= $t->rating ? '-fill' : '' }}"></i>
                @endfor
              </div>
              <p class="mb-0">{{ $t->content }}</p>
              <p class="mt-2 mb-0">
                <strong>— {{ $t->name }}</strong>
                @if($t->role), <span class="text-muted">{{ $t->role }}</span>@endif
              </p>
            </article>
          </div>
        @empty
          <p class="text-center text-muted col-12">Reviews coming soon.</p>
        @endforelse
      </div>
    </div>
  </section>

  {{-- Contact / Quote Form --}}
  <section class="contact-section" id="contact">
    <div class="container-xxl">
      <div class="row g-5 align-items-start">
        <div class="col-lg-6">
          <h2 class="section-title section-title--left">{{ $cta?->title ?? 'Contact Us for a Free Quote!' }}</h2>
          <p class="contact-copy">{{ $cta?->subtitle ?? "Thank you for your interest. To request an online estimate please use the form. We'll get back to you ASAP." }}</p>

          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <form class="quote-form" method="POST" action="{{ route('contact.store') }}" novalidate>
            @csrf
            <div class="row g-3">
              <div class="col-12">
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                       placeholder="Full Name *" value="{{ old('name') }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6">
                <input class="form-control" type="tel" name="phone"
                       placeholder="Phone No." value="{{ old('phone') }}">
              </div>
              <div class="col-md-6">
                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                       placeholder="Email Address *" value="{{ old('email') }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-12">
                <textarea class="form-control @error('message') is-invalid @enderror" name="message"
                          placeholder="Enter your message...">{{ old('message') }}</textarea>
                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <button class="btn btn-submit" type="submit">Submit</button>
          </form>
        </div>
        <div class="col-lg-6">
          <div class="map-frame">
            @if(setting('map_embed_url'))
              {!! setting('map_embed_url') !!}
            @else
              <img src="{{ asset('assets/images/map.png') }}" alt="Service area map">
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const slider = document.getElementById("homeBannerSlider");
    if (!slider || !window.bootstrap?.Carousel) return;
    window.bootstrap.Carousel.getOrCreateInstance(slider, {
      interval: 3000, pause: false, ride: "carousel", touch: true, wrap: true
    }).cycle();
  });
</script>
@endpush
