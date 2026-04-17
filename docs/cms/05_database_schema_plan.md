# 05 — Database Schema Plan

## Reused Tables (no changes needed)

| Table | Model | Notes |
|---|---|---|
| `users` | `User` | Admins use role `admin` via Spatie |
| `site_settings` | `SiteSetting` | key/value, cached |
| `banners` | `Banner` | title, subtitle, button_text, button_url, image, page, is_active, sort_order |
| `homepage_sections` | `HomepageSection` | section_key, title, subtitle, content, is_active, sort_order, settings (JSON) |
| `blogs` | `Blog` | slug, title, content, excerpt, image, is_active, published_at, meta fields |
| `blog_categories` | `BlogCategory` | name, slug |
| `pages` | `Page` | title, slug, content, is_active, meta fields |
| `faqs` | `Faq` | question, answer, is_active, sort_order |
| `contact_inquiries` | `ContactInquiry` | name, email, phone, message, is_read |
| `newsletter_subscribers` | `NewsletterSubscriber` | email, is_active |
| `media` | `Media` | file_name, file_path, file_type, file_size, mime_type |
| `roles`, `permissions`, etc. | Spatie | Permission tables |

---

## New Tables

### `services`

```sql
id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
title           VARCHAR(200) NOT NULL
slug            VARCHAR(220) UNIQUE NOT NULL
excerpt         VARCHAR(500) NULL          -- short card description
description     TEXT NULL                  -- full rich text
features        JSON NULL                  -- ["Feature 1", "Feature 2"]
icon_class      VARCHAR(100) NULL          -- Bootstrap icon e.g. bi-house-check
image           VARCHAR(500) NULL          -- storage path
is_active       TINYINT(1) DEFAULT 1
sort_order      INT DEFAULT 0
meta_title      VARCHAR(200) NULL
meta_description VARCHAR(500) NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### `testimonials`

```sql
id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
name            VARCHAR(150) NOT NULL
role            VARCHAR(150) NULL          -- e.g. "Homeowner" or "Office Manager"
content         TEXT NOT NULL
avatar          VARCHAR(500) NULL          -- storage path (optional)
rating          TINYINT DEFAULT 5          -- 1–5
is_active       TINYINT(1) DEFAULT 1
sort_order      INT DEFAULT 0
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

---

## Site Settings Keys (seed these)

These are key-value rows in the `site_settings` table.

| Key | Example Value | Used In |
|---|---|---|
| `site_name` | MDS Cleaning | Admin title, `<title>` |
| `site_tagline` | One Call Cleans It All | Footer, meta |
| `logo` | `assets/images/logo-mds.png` | Header |
| `favicon` | `assets/images/favicon.png` | `<link rel="icon">` |
| `phone` | 8179890656 | Header, footer, contact |
| `whatsapp` | 18179890656 | Top strip |
| `email` | info@mdscleaning.com | Contact |
| `address` | Dallas/Fort Worth, TX | Contact, footer |
| `business_hours` | Mon–Sat: 7am–7pm | Contact |
| `map_embed_url` | Google Maps embed URL | Contact page |
| `facebook_url` | | Top strip, footer |
| `instagram_url` | | Top strip, footer |
| `announcement_text` | Accepting Commercial Cleaning Contracts... | Top strip |
| `footer_tagline` | Reliable cleaning professionals... | Footer |
| `meta_title` | MDS Cleaning — Dallas/Fort Worth | Default SEO |
| `meta_description` | Residential & commercial cleaning... | Default SEO |

---

## homepage_sections Keys (seed these rows)

| section_key | Usage Page |
|---|---|
| `intro` | Home — who we are text block |
| `why_choose` | Home — trust badges strip |
| `cta` | Home — bottom call-to-action |
| `clients` | Home — client logos |
| `about_hero` | About — page hero |
| `about_story` | About — founder/story section |
| `about_why` | About — 4 numbered reasons |
| `about_details` | About — detail cards |
| `services_hero` | Services — page hero |
| `service_guarantees` | Services — guarantee cards |
| `contact_hero` | Contact — page hero |

---

## Relationships

```
Blog  →belongs to→  BlogCategory
Service  (standalone)
Testimonial  (standalone)
HomepageSection  (standalone, keyed)
Banner  (standalone, paged)
ContactInquiry  (standalone)
SiteSetting  (standalone, keyed)
```

---

## Field Conventions (follow existing project patterns)

| Field | Type | Notes |
|---|---|---|
| `slug` | VARCHAR UNIQUE | Auto-generated via `SlugService` |
| `is_active` | TINYINT(1) | Cast to boolean in model |
| `sort_order` | INT DEFAULT 0 | Lower = first |
| `image` | VARCHAR(500) | Relative storage path, resolved by `getImageUrlAttribute()` |
| `settings` | JSON | Cast to array in model |
| `meta_title` | VARCHAR(200) | SEO |
| `meta_description` | VARCHAR(500) | SEO |
| `features` | JSON | Array of strings |
