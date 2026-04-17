# 09 — Prompt Templates for Module Generation

---

## Template A — New Admin CRUD Module

Use this for Services, Testimonials, or any future new module.

```
Generate the [MODULE NAME] module for the MDS Cleaning Laravel CMS project.

Context:
- Laravel 11 project at c:/xampp/htdocs/mds_cleaning
- Reusing existing admin architecture — do NOT recreate boilerplate
- Copy the controller pattern from Admin/[REFERENCE_CONTROLLER].php
- Copy the view pattern from admin/[REFERENCE_VIEW_FOLDER]/
- Use MediaService for image uploads (already injected in similar controllers)
- Use the existing admin layout: layouts/admin.blade.php
- Follow existing route naming: admin.[module].[action]

Required files (generate only these):
1. Migration: create_[table]_table.php
   Fields: [list fields from 05_database_schema_plan.md]

2. Model: app/Models/[Model].php
   - fillable, casts (is_active→bool, sort_order→int, features/settings→array)
   - scopeActive(), ordered by sort_order
   - getImageUrlAttribute() if has image

3. Controller: app/Http/Controllers/Admin/[Model]Controller.php
   - Methods: index, create, store, edit, update, destroy, toggle
   - Image upload: $this->media->store($file, '[folder]', [800, 500])
   - Slug generation: SlugService if has slug field

4. Views:
   - resources/views/admin/[module]/index.blade.php (table list with status toggle)
   - resources/views/admin/[module]/create.blade.php (create/edit form, shared)

5. Routes to add in web.php admin group:
   [paste route block]

6. Sidebar link to add in layouts/admin.blade.php:
   [show exact nav-link line]

Rules:
- Do not regenerate MediaService, SlugService, or existing helpers
- Do not regenerate the admin layout — only provide the sidebar addition
- Do not show web.php in full — only the new route block
- Keep code minimal and matching existing style
```

---

## Template B — Update Existing Frontend Controller

Use this when an existing frontend controller needs CMS data instead of e-commerce data.

```
Update Frontend/[Controller].php for the MDS Cleaning CMS.

Context:
- File exists at app/Http/Controllers/Frontend/[Controller].php
- Currently loads e-commerce data — needs to load CMS data instead
- Do not change the method signature or route
- Do not remove other methods in the file

The [methodName]() method should now:
- Load: [list specific models and scopes, e.g. Banner::active()->forPage('home')->get()]
- Pass to view: [list variable names]
- Return view: [view path]

Show only the updated method body, not the full file.
```

---

## Template C — HTML Page to Blade Conversion

Use this for each of the 4 HTML pages.

```
Convert html-source/[filename].html to a Laravel Blade file for MDS Cleaning.

Context:
- Project: c:/xampp/htdocs/mds_cleaning
- The layout file already exists: resources/views/layouts/website.blade.php
- Partials already done: partials/website/topstrip, header, footer
- These are ALREADY in the layout — do NOT include header/footer in the output
- Copy only the <main> section content

Output file: resources/views/frontend/[page]/index.blade.php

Structure:
@extends('layouts.website')
@section('meta_title', '[Page Title] — MDS Cleaning')
@section('content')
  {{-- converted main content here --}}
@endsection

Dynamic data variables passed from controller:
[list variables, e.g. $banners, $services, $sections]

Blade conversion rules:
- static text that should be CMS-managed → {{ $variable }}
- loops for repeated cards → @foreach
- image src → {{ asset('assets/images/filename.jpg') }} for static, Storage::url() for uploaded
- internal links → {{ route('route.name') }}
- HTML content → {!! $var !!}

Do NOT include:
- <html>, <head>, <body> tags
- header or footer markup
- CSS link tags
- script tags (use @push('scripts') only if JS is page-specific)
```

---

## Template D — Reuse Analysis for a Specific File

Use this when you're unsure whether an existing file can be reused.

```
Analyze this existing file for reuse in the MDS Cleaning CMS project:
[paste or reference file path]

Tell me:
1. Which parts can be kept as-is
2. Which parts need to change (and what to change them to)
3. Which parts are e-commerce-specific and should be removed/replaced
4. Which imports/dependencies are still needed vs removable

Output as a short bullet list. No long explanations.
```

---

## Template E — Settings Form Update

```
Add these new fields to the existing admin settings form.
File: resources/views/admin/settings/index.blade.php

Existing file uses [Bootstrap 5 form-group pattern / whatever pattern].

Add the following fields in a new section labelled "Contact & Social":
- phone (text input, key: phone)
- whatsapp (text input, key: whatsapp)
- email (text input, key: email)
- address (textarea, key: address)
- business_hours (text input, key: business_hours)
- facebook_url (text input, key: facebook_url)
- instagram_url (text input, key: instagram_url)
- map_embed_url (textarea, key: map_embed_url)
- announcement_text (text input, key: announcement_text)

Show only the new HTML block to insert — not the full file.
Existing form action and CSRF are already present.
```

---

## Template F — Admin Sidebar Update

```
Update the sidebar in resources/views/layouts/admin.blade.php.

Do NOT regenerate the full file. Show only:
1. The new nav-link lines to ADD for: Services, Testimonials
2. The nav-link lines to COMMENT OUT for: Products, Categories, Collections, Attributes, Inventory, Orders, Customers, Coupons, Sellers

Follow the exact existing nav-link HTML pattern in the file.
```

---

## Template G — Migration Only

```
Generate migration file for [table_name].

Follow the exact format of: database/migrations/2024_01_01_000021_create_banners_table.php

Table: [table_name]
Fields:
[paste field list from 05_database_schema_plan.md]

Output only the migration class. No model, no controller.
```
