# 08 — Token Optimization Rules

## Core Principle
**Reuse first. Generate only what is missing. Patch, don't rewrite.**

---

## Rule 1 — Inspect Before Generating

Before asking Claude to generate any file, always state:
- "This file already exists at `path/to/file.php`"
- "Follow the same pattern as `BannerController.php`"
- "The model already has these fields: …"

This prevents Claude from generating full boilerplate and instead produces targeted additions.

---

## Rule 2 — Controller Generation

### Instead of:
> "Generate a full ServiceController with all CRUD methods"

### Say:
> "Generate `Admin/ServiceController.php` following the exact same pattern as `Admin/BannerController.php`.
> The model is `Service` (fillable: title, slug, excerpt, description, features, icon_class, image, is_active, sort_order).
> Image upload uses `MediaService::store($file, 'services', [800, 600])`.
> No need to repeat the MediaService injection pattern — same as Banner."

**Token saving: ~60%** compared to full from-scratch generation.

---

## Rule 3 — View Generation

### Instead of:
> "Generate a complete admin CRUD view for services"

### Say:
> "Generate `admin/services/index.blade.php` and `admin/services/create.blade.php`.
> Copy the structure from `admin/banners/index.blade.php` and `admin/banners/create.blade.php`.
> Change column names to: title, sort_order, is_active, image.
> Add icon_class text input and features textarea (comma-separated)."

**Token saving: ~70%** — blade structure not regenerated.

---

## Rule 4 — HTML to Blade Conversion

### Instead of:
> "Convert the entire HTML file to blade"

### Say:
> "Convert `html-source/services.html` to `frontend/services/index.blade.php`.
> Use `@extends('layouts.website')`.
> The layout and partials (topstrip, header, footer) are already done.
> Only convert the `<main>` content.
> Replace static service cards with `@foreach($services as $service)` loop.
> Asset paths: `src='assets/…'` → `{{ asset('assets/images/…') }}`."

**Token saving: ~50%** — layout/partials not repeated.

---

## Rule 5 — Route Updates

### Instead of:
> "Show me the full routes file with services routes added"

### Say:
> "Add these routes to the admin group in `routes/web.php` after the banners block:
> [paste only the new route lines]"

**Never request full `web.php` regeneration.**

---

## Rule 6 — Model Generation

### Instead of:
> "Generate a Service model"

### Say:
> "Generate `app/Models/Service.php`.
> Same structure as `Banner.php` (scopes: active, sorted).
> Fields: title, slug, excerpt, description, features (JSON cast), icon_class, image, is_active (bool cast), sort_order (int cast), meta_title, meta_description.
> Include `getImageUrlAttribute()` identical to Banner model."

---

## Rule 7 — Migration Generation

### Instead of:
> "Generate a migration for services"

### Say:
> "Generate migration `create_services_table`.
> Fields: id, title, slug (unique), excerpt (nullable), description (text nullable), features (json nullable), icon_class (nullable), image (nullable), is_active (default 1), sort_order (default 0), meta_title (nullable), meta_description (nullable), timestamps.
> Follow the same format as `2024_01_01_000021_create_banners_table.php`."

---

## Rule 8 — Settings Update

### Instead of:
> "Update the settings controller and view"

### Say:
> "In `admin/settings/index.blade.php`, add these new input fields after the existing ones:
> [list only the new fields with their keys]
> Do not regenerate existing fields."

---

## Rule 9 — One Module Per Prompt

Always work on **one module at a time**. Do not ask for:
- All admin CRUDs in one prompt
- All frontend pages in one prompt
- All migrations at once

Sequence: migration → model → controller → views → routes → test → next module.

---

## Rule 10 — Reference Existing Files Explicitly

Always tell Claude which existing file to copy from:

| New File | Copy Pattern From |
|---|---|
| `Admin/ServiceController` | `Admin/BannerController` |
| `Admin/TestimonialController` | `Admin/FaqController` (simpler, no image) |
| `admin/services/index.blade.php` | `admin/banners/index.blade.php` |
| `admin/services/create.blade.php` | `admin/banners/create.blade.php` |
| `admin/testimonials/index.blade.php` | `admin/faqs/index.blade.php` |
| `frontend/home/index.blade.php` | Convert `html-source/index.html` |
| `Service` model | `Banner` model |
| `Testimonial` model | `Faq` model (no image version) |

---

## Anti-Patterns to Avoid

| Don't Do | Do Instead |
|---|---|
| Ask for full `web.php` | Ask for specific route block additions |
| Ask for full admin layout | Ask for specific sidebar link additions |
| Ask for all controllers at once | One controller per prompt |
| Ask for full HTML conversion | Convert one page at a time, after layout is done |
| Ask for all settings fields | List only new keys to add |
| Regenerate existing models | Reference them and build on top |
| Ask Claude to "create the whole CMS" | Follow the phase sequence in `07_implementation_sequence.md` |
