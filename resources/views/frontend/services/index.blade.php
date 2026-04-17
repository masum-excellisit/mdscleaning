@extends('layouts.website')

@section('meta_title', 'Services | ' . setting('site_name', 'MDS Cleaning'))

@section('content')
<main>

  {{-- Page Hero --}}
  <section class="page-hero page-hero--services">
    <div class="container-xxl page-hero__container">
      <div class="page-hero__content">
        <span class="page-hero__eyebrow">{{ $hero?->subtitle ?? 'Cleaning Solutions' }}</span>
        <h1>{{ $hero?->title ?? 'Services' }}</h1>
        @if($hero?->content)
          <p>{!! $hero->content !!}</p>
        @else
          <p>From recurring residential care to move-in/move-out support and dependable commercial cleaning, MDS Cleaning offers flexible service options tailored to the way your space is used.</p>
        @endif
      </div>
    </div>
  </section>

  {{-- Service Cards Grid --}}
  <section class="services-section">
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

  {{-- Service Details --}}
  @if($services->isNotEmpty())
  <section class="subpage-section">
    <div class="container-xxl">
      <h2 class="section-title text-center">Cleaning Services for Every Space</h2>
      <div class="row g-4">
        @foreach($services as $service)
          <div class="col-lg-4">
            <article class="service-detail">
              <img src="{{ $service->image_url }}" alt="{{ $service->title }}">
              <div class="service-detail__body">
                <h3 class="service-detail__title">{{ $service->title }}</h3>
                @if($service->description)
                  <p>{{ $service->description }}</p>
                @elseif($service->excerpt)
                  <p>{{ $service->excerpt }}</p>
                @endif
                @if($service->features)
                  <ul class="checklist">
                    @foreach($service->features as $feature)
                      <li>
                        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                        <span>{{ $feature }}</span>
                      </li>
                    @endforeach
                  </ul>
                @endif
              </div>
            </article>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- Guarantees / How It Works --}}
  <section class="subpage-section subpage-section--alt">
    <div class="container-xxl">
      <h2 class="section-title text-center">{{ $guarantees?->title ?? 'Simple, Flexible Scheduling' }}</h2>
      <div class="row g-4">
        @php $guaranteeCards = $guarantees?->settings['cards'] ?? [
          ['icon' => 'bi-envelope-paper-fill', 'title' => 'Request a Quote',        'text' => 'Reach out with your property type, timing, and cleaning needs so we can recommend the service that fits best.'],
          ['icon' => 'bi-calendar-check-fill', 'title' => 'Confirm the Plan',       'text' => 'We align on your cleaning priorities, preferred schedule, and any special requests before service begins.'],
          ['icon' => 'bi-house-check-fill',    'title' => 'Enjoy a Cleaner Space',  'text' => 'Our team arrives ready to deliver the professional, detail-conscious cleaning experience clients expect from MDS Cleaning.'],
        ]; @endphp
        @foreach($guaranteeCards as $card)
          <div class="col-lg-4">
            <article class="detail-card">
              <div class="detail-card__icon"><i class="bi {{ $card['icon'] }}" aria-hidden="true"></i></div>
              <h3>{{ $card['title'] }}</h3>
              <p>{{ $card['text'] }}</p>
            </article>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Mini CTA --}}
  <section class="mini-cta">
    <div class="container-xxl">
      <div class="mini-cta__box">
        <h2>{{ $ctaServices?->title ?? 'Need help choosing the right service?' }}</h2>
        <p>{!! $ctaServices?->content ?? 'Share a few details about your home, move, or commercial property and we\'ll point you to the best option for your space and schedule.' !!}</p>
        <a class="btn btn-quote" href="{{ route('contact.index') }}">
          <i class="bi bi-calendar3" aria-hidden="true"></i>
          <span>{{ $ctaServices?->subtitle ?? 'Get a Quote' }}</span>
        </a>
      </div>
    </div>
  </section>

</main>
@endsection
