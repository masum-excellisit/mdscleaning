# 01 — Project Overview

## Project Name
**MDS Cleaning** — Laravel CMS Website

## Goal
Convert a completed HTML website design (4 pages) for a cleaning services company into a fully
dynamic Laravel CMS, reusing the existing Laravel 11 e-commerce project as the foundation.

---

## Source Inputs

| Input | Description |
|---|---|
| Existing Laravel 11 project | Base project at `c:/xampp/htdocs/mds_cleaning` |
| HTML source | 4 pages: `index.html`, `about.html`, `services.html`, `contact.html` |
| Assets | `html-source/assets/` — logo, hero images, service images, client photos |

---

## Reuse Strategy

The existing project already contains **most of what is needed**:

| Already Exists | Status |
|---|---|
| Laravel 11 framework | Reuse as-is |
| Admin layout (`layouts/admin.blade.php`) | Reuse as-is |
| Auth system (Login/Register/Forgot/Reset) | Reuse as-is |
| `AdminMiddleware` with role-based access | Reuse as-is |
| `MediaService` — upload, resize, store | Reuse as-is |
| `SlugService` | Reuse as-is |
| `setting()` global helper | Reuse as-is |
| `active_class()` helper | Reuse as-is |
| `SiteSetting` model + cache layer | Reuse as-is |
| `Banner` model + admin CRUD | Reuse as-is |
| `HomepageSection` model + admin CRUD | Reuse as-is |
| `Blog` + `BlogCategory` models + admin CRUD | Reuse as-is |
| `Page` model + admin CRUD | Reuse as-is |
| `Faq` model + admin CRUD | Reuse as-is |
| `ContactInquiry` model + admin CRUD | Reuse as-is |
| `NewsletterSubscriber` model + admin CRUD | Reuse as-is |
| `Media` library + admin picker | Reuse as-is |
| `SettingController` — admin settings page | Reuse as-is |
| Spatie Permissions (roles/middleware) | Reuse as-is |
| Migrations for all above | Reuse as-is |

---

## What is New / Missing

| Needed for MDS CMS | Status |
|---|---|
| `Service` model + admin CRUD | **New** |
| `Testimonial` model + admin CRUD | **New** |
| Frontend blade layout for MDS design | **New** |
| Frontend blade pages (home, about, services, contact) | **New** |
| Frontend controllers (CMS version) | **Update existing stubs** |
| Services migration | **New** |
| Testimonials migration | **New** |
| Admin sidebar — CMS menu items | **Update existing sidebar** |
| Site settings keys for MDS (phone, email, address, socials) | **Seed/update** |

---

## Overall Implementation Approach

1. **Reuse** all admin infrastructure (layout, auth, media, settings, CRUD patterns).
2. **Add** two new modules: Services, Testimonials.
3. **Convert** 4 HTML pages into Blade, extracting shared partials.
4. **Wire** existing models (Banner, HomepageSection, Blog, Faq, ContactInquiry, SiteSetting) to the new frontend.
5. **Seed** site_settings with MDS-specific default values.
6. **Remove** e-commerce routes/sidebar links from admin navigation (leave underlying code untouched to avoid breakage).

---

## Technology Stack

| Layer | Tech |
|---|---|
| Framework | Laravel 11 |
| Admin UI | Bootstrap 5 + Bootstrap Icons (already in admin layout) |
| Frontend UI | Bootstrap 5 + Bootstrap Icons + custom `style.css` |
| Auth | Custom (LoginController, AdminMiddleware, Spatie Roles) |
| File Storage | Laravel Storage (public disk) via `MediaService` |
| DB | MySQL (XAMPP) |
| Cache | File cache (settings, etc.) |
