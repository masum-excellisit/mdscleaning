@extends('layouts.website')

@section('meta_title', 'About Us | ' . setting('site_name', 'MDS Cleaning'))

@section('content')
<main>

  {{-- Page Hero --}}
  <section class="page-hero page-hero--about">
    <div class="container-xxl page-hero__container">
      <div class="page-hero__content">
        <span class="page-hero__eyebrow">{{ $hero?->subtitle ?? 'Trusted Cleaning Professionals' }}</span>
        <h1>{{ $hero?->title ?? 'About Us' }}</h1>
        @if($hero?->content)
          <p>{!! $hero->content !!}</p>
        @else
          <p>MDS Cleaning is built around dependable service, respectful communication, and detail-focused cleaning support for homes and businesses across the greater Dallas/Ft. Worth area.</p>
        @endif
      </div>
    </div>
  </section>

  {{-- Founder / Story --}}
  <section class="subpage-section">
    <div class="container-xxl">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <h2 class="section-title section-title--left">{{ $story?->title ?? 'Meet Our Founder' }}</h2>
          @if($story?->content)
            {!! $story->content !!}
          @else
            <p class="lead-paragraph">Marquis Dawuane Simmons launched MDS Cleaning in July 2018. With nearly 10 years of cleaning experience, he created the business around the kind of consistency clients can count on from the first visit forward.</p>
            <p class="lead-paragraph mb-0">From residential spaces to commercial properties, the goal remains the same: show up on time, work carefully, communicate clearly, and deliver a level of cleanliness that feels professional and trustworthy every time.</p>
          @endif
        </div>
        <div class="col-lg-5">
          @php $storyImg = $story?->settings['image'] ?? 'assets/images/founder.jpg'; @endphp
          <img class="founder-photo" src="{{ asset($storyImg) }}" alt="Founder of MDS Cleaning">
        </div>
      </div>
    </div>
  </section>

  {{-- Why Choose Us --}}
  <section class="why-section">
    <div class="container-xxl">
      <h2 class="section-title section-title--left">{{ $why?->title ?? 'Why Choose Us?' }}</h2>
      <div class="row g-4">
        @php $whyItems = $why?->settings['items'] ?? [
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

  {{-- What Clients Can Expect --}}
  <section class="subpage-section subpage-section--alt">
    <div class="container-xxl">
      <h2 class="section-title text-center">{{ $details?->title ?? 'What Clients Can Expect' }}</h2>
      <div class="row g-4">
        @php $detailCards = $details?->settings['cards'] ?? [
          ['icon' => 'bi-chat-dots-fill', 'title' => 'Clear Communication',  'text' => 'We make it easy to request a quote, confirm details, and stay aligned on exactly what your property needs before cleaning begins.'],
          ['icon' => 'bi-shield-check',   'title' => 'Trusted Service',      'text' => 'Every visit is guided by care, reliability, and professional standards that help clients feel comfortable inviting MDS Cleaning into their space.'],
          ['icon' => 'bi-calendar2-week-fill', 'title' => 'Flexible Scheduling', 'text' => 'We offer scheduling options that work for busy households and businesses, including evenings and weekends when needed.'],
        ]; @endphp
        @foreach($detailCards as $card)
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
        <h2>{{ $ctaAbout?->title ?? 'Ready to work with a team that shows up and gets it done right?' }}</h2>
        <p>{!! $ctaAbout?->content ?? "Tell us about your home, office, or move-in/move-out needs and we'll help you choose the right cleaning support for your space." !!}</p>
        <a class="btn btn-quote" href="{{ route('contact.index') }}">
          <i class="bi bi-calendar3" aria-hidden="true"></i>
          <span>{{ $ctaAbout?->subtitle ?? 'Get a Quote' }}</span>
        </a>
      </div>
    </div>
  </section>

</main>
@endsection
