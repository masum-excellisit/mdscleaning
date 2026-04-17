<header class="site-header">
  <div class="container-xxl">
    <nav class="navbar navbar-expand-lg p-0" aria-label="Primary navigation">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('assets/images/logo-mds.png') }}" alt="{{ setting('site_name', 'MDS Cleaning') }} logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#siteNav" aria-controls="siteNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="siteNav">
        <ul class="navbar-nav mx-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link {{ active_class('home') }}" href="{{ route('home') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link {{ active_class('about') }}" href="{{ route('about') }}">About Us</a></li>
          <li class="nav-item"><a class="nav-link {{ active_class('services') }}" href="{{ route('services') }}">Services</a></li>
          <li class="nav-item"><a class="nav-link {{ active_class('contact.*') }}" href="{{ route('contact.index') }}">Contact Us</a></li>
        </ul>
        <a class="btn btn-book" href="{{ route('contact.index') }}">Book Now</a>
      </div>
    </nav>
  </div>
</header>
