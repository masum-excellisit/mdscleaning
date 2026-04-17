@extends('layouts.website')

@section('meta_title', 'Contact Us | ' . setting('site_name', 'MDS Cleaning'))

@section('content')
<main>

  {{-- Page Hero --}}
  <section class="page-hero page-hero--contact">
    <div class="container-xxl page-hero__container">
      <div class="page-hero__content">
        <span class="page-hero__eyebrow">Let's Talk</span>
        <h1>Contact Us</h1>
        <p>Whether you need residential cleaning, move-in/move-out support, or commercial service, reach out and we'll help you get started with a quote.</p>
      </div>
    </div>
  </section>

  {{-- Contact Info Cards --}}
  <section class="subpage-section">
    <div class="container-xxl">
      <div class="row g-4">
        <div class="col-lg-4">
          <article class="contact-card">
            <div class="contact-card__icon"><i class="bi bi-telephone-fill" aria-hidden="true"></i></div>
            <h3>Call or Text</h3>
            <p><a href="tel:{{ setting('phone', '8179890656') }}">{{ setting('phone', '817-989-0656') }}</a></p>
          </article>
        </div>
        <div class="col-lg-4">
          <article class="contact-card">
            <div class="contact-card__icon"><i class="bi bi-envelope-fill" aria-hidden="true"></i></div>
            <h3>Email Us</h3>
            <p><a href="mailto:{{ setting('email', 'mds.cleaningservice@yahoo.com') }}">{{ setting('email', 'mds.cleaningservice@yahoo.com') }}</a></p>
          </article>
        </div>
        <div class="col-lg-4">
          <article class="contact-card">
            <div class="contact-card__icon"><i class="bi bi-clock-fill" aria-hidden="true"></i></div>
            <h3>Operating Hours</h3>
            <p>{!! nl2br(e(setting('business_hours', "Mon - Fri: 8am - 8pm\nSaturday: 9am - 7pm\nSunday: 9am - 8pm"))) !!}</p>
          </article>
        </div>
      </div>
    </div>
  </section>

  {{-- Quote Form + Map --}}
  <section class="contact-section contact-section--page">
    <div class="container-xxl">
      <div class="row g-5 align-items-start">
        <div class="col-lg-6">
          <h2 class="section-title section-title--left">Contact Us for a Free Quote!</h2>
          <p class="contact-copy">Thank you for your interest. To request an online estimate please use the form. We'll get back to you ASAP.</p>

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

  {{-- Notice Band --}}
  <section class="notice-band">
    <div class="container-xxl">
      <div class="notice-band__box">
        <h2 class="notice-band__title">Serving Carrollton and the Greater Dallas/Ft. Worth Area</h2>
        <p>Let us know whether you need help with a home, apartment, office, or another small to medium sized property. We'll review your request, discuss timing, and help you move forward with the service that fits best.</p>
      </div>
    </div>
  </section>

</main>
@endsection
