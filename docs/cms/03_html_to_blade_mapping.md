# 03 — HTML to Blade Mapping

## HTML Source Files

| HTML File | Blade Target | Route | Purpose |
|---|---|---|---|
| `index.html` | `resources/views/frontend/home/index.blade.php` | `GET /` | Home page |
| `about.html` | `resources/views/frontend/about/index.blade.php` | `GET /about` | About page |
| `services.html` | `resources/views/frontend/services/index.blade.php` | `GET /services` | Services listing |
| `contact.html` | `resources/views/frontend/contact/index.blade.php` | `GET /contact` | Contact + form |
| `style.css` | `public/assets/css/website.css` | — | Global frontend CSS |
| `assets/*` | `public/assets/images/` | — | Images |

---

## Shared Layout

**New file:** `resources/views/layouts/website.blade.php`

Replaces the current `app.blade.php` (which is e-commerce themed).

Includes:
- `<head>` with Google Fonts, Bootstrap 5 CDN, Bootstrap Icons CDN, `website.css`
- `@include('partials.website.topstrip')` — top announcement bar
- `@include('partials.website.header')` — site navigation
- `@yield('content')`
- `@include('partials.website.footer')`
- Scripts block

---

## Partials to Extract

| Partial File | Source HTML Section | Dynamic Data |
|---|---|---|
| `partials/website/topstrip.blade.php` | `<div class="top-strip">` | `setting('phone')`, `setting('whatsapp')`, `setting('announcement_text')` |
| `partials/website/header.blade.php` | `<header class="site-header">` | Logo from `setting('logo')`, nav links (static for now) |
| `partials/website/footer.blade.php` | `<footer class="site-footer">` (from index.html bottom) | `setting('footer_tagline')`, `setting('phone')`, `setting('email')`, `setting('address')`, socials |

---

## Page-by-Page Section Mapping

### index.html → `frontend/home/index.blade.php`

| HTML Section / Class | Dynamic Source | DB Table | Notes |
|---|---|---|---|
| `.hero-section` carousel (3 slides) | `Banner::active()->forPage('home')` | `banners` | title, subtitle, button_text, button_url, image |
| `.intro-section` (who we are text + image) | `HomepageSection::get('intro')` | `homepage_sections` | title, content, settings->image |
| `.services-section` (3 service cards) | `Service::active()->orderBy('sort_order')` | `services` | title, excerpt, icon_class, image |
| `.why-section` (trust badge strip) | `HomepageSection::get('why_choose')` | `homepage_sections` | settings JSON array of items |
| `.testimonials-section` | `Testimonial::active()->orderBy('sort_order')` | `testimonials` | name, role, content, avatar |
| `.clients-section` (logos strip) | `HomepageSection::get('clients')` | `homepage_sections` | settings JSON array of logos |
| `.cta-section` (bottom CTA) | `HomepageSection::get('cta')` | `homepage_sections` | title, subtitle, button_text, button_url |

### about.html → `frontend/about/index.blade.php`

| HTML Section / Class | Dynamic Source | DB Table | Notes |
|---|---|---|---|
| `.page-hero--about` | `HomepageSection::get('about_hero')` | `homepage_sections` | title, subtitle, bg image via settings |
| `.subpage-section` (story + founder image) | `HomepageSection::get('about_story')` | `homepage_sections` | title, content, settings->image |
| `.why-section` (4 numbered reasons) | `HomepageSection::get('about_why')` | `homepage_sections` | settings JSON array |
| `.subpage-section--alt` (detail cards) | `HomepageSection::get('about_details')` | `homepage_sections` | settings JSON array of icon/text cards |

### services.html → `frontend/services/index.blade.php`

| HTML Section / Class | Dynamic Source | DB Table | Notes |
|---|---|---|---|
| `.page-hero--services` | `HomepageSection::get('services_hero')` | `homepage_sections` | title, subtitle |
| `.services-section` (3 card grid) | `Service::active()->orderBy('sort_order')` | `services` | title, excerpt, icon_class, image |
| `.subpage-section` (detailed 3-col) | `Service::active()->orderBy('sort_order')` | `services` | title, description, features JSON |
| `.subpage-section--alt` (guarantee cards) | `HomepageSection::get('service_guarantees')` | `homepage_sections` | settings JSON |

### contact.html → `frontend/contact/index.blade.php`

| HTML Section / Class | Dynamic Source | DB Table | Notes |
|---|---|---|---|
| `.page-hero--contact` | `HomepageSection::get('contact_hero')` | `homepage_sections` | title, subtitle |
| `.contact-card` ×3 (phone/email/hours) | `setting('phone')`, `setting('email')`, `setting('business_hours')` | `site_settings` | |
| Contact form | POST `/contact` → `ContactInquiry` | `contact_inquiries` | Reuse existing `ContactController@store` |
| Map embed | `setting('map_embed_url')` | `site_settings` | iframe src |

---

## Asset Migration

| Source | Destination | Notes |
|---|---|---|
| `html-source/style.css` | `public/assets/css/website.css` | Copy as-is |
| `html-source/assets/*.jpg` | `public/assets/images/*.jpg` | Copy all images |
| `html-source/assets/logo-mds.png` | `public/assets/images/logo-mds.png` | Used in header partial |

Update all `src="assets/…"` to `{{ asset('assets/images/…') }}` in blade files.
Update `href="style.css"` to `{{ asset('assets/css/website.css') }}`.

---

## Internal Link Replacements

| Old HTML Link | New Blade Link |
|---|---|
| `href="index.html"` | `href="{{ route('home') }}"` |
| `href="about.html"` | `href="{{ route('about') }}"` |
| `href="services.html"` | `href="{{ route('services') }}"` |
| `href="contact.html"` | `href="{{ route('contact.index') }}"` |
| `href="tel:8179890656"` | `href="tel:{{ setting('phone', '8179890656') }}"` |
| `href="https://wa.me/…"` | `href="https://wa.me/{{ setting('whatsapp', '18179890656') }}"` |

---

## Dynamic Field Placeholder Convention

In blade files use `{{ }}` for escaped output. Where sections may have HTML, use `{!! !!}`:

```blade
{!! $section->content !!}   {{-- rich text from admin --}}
{{ $banner->title }}         {{-- plain text --}}
```
