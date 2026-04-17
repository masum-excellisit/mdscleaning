# 04 — CMS Module Plan

## Module Status Legend
- ✅ Already exists — full reuse
- 🔄 Exists — needs minor update
- 🆕 New — must be created

---

## Module List

### 1. Admin Auth ✅
- Admin login / logout / password reset
- Role-based access via `AdminMiddleware`
- **Reuse:** `Auth/LoginController`, `AdminMiddleware`, all auth views
- **Frontend:** `/admin/login`

---

### 2. Dashboard ✅
- Stats overview (counts of inquiries, blogs, services, etc.)
- **Reuse:** `Admin/DashboardController`
- **Update:** Add counts for Services, Testimonials
- **Frontend:** `/admin`

---

### 3. Banners ✅
- Manage home page hero carousel slides
- Fields: title, subtitle, button_text, button_url, image, page, is_active, sort_order
- **Reuse:** `Admin/BannerController`, `Banner` model, `admin/banners` views
- **Admin menu:** Banners

---

### 4. Homepage Sections ✅
- Manage editable content blocks (intro, why, cta, heroes, etc.)
- Fields: section_key, title, subtitle, content (rich text), is_active, settings (JSON)
- **Reuse:** `Admin/HomepageSectionController`, `HomepageSection` model
- **Admin menu:** Homepage Sections

---

### 5. Services 🆕
- CRUD for cleaning service cards shown on home and services page
- Fields: title, excerpt, description, features (JSON), icon_class, image, is_active, sort_order, meta_title, meta_description
- **New:** `Service` model, migration, `Admin/ServiceController`, `admin/services` views
- **Frontend:** services listing on home page + full services page
- **Admin menu:** Services

---

### 6. Testimonials 🆕
- CRUD for client testimonials shown on home page
- Fields: name, role/company, content, avatar, rating (1-5), is_active, sort_order
- **New:** `Testimonial` model, migration, `Admin/TestimonialController`, `admin/testimonials` views
- **Admin menu:** Testimonials

---

### 7. Blogs ✅
- Blog post management with categories
- Fields: title, slug, content, excerpt, image, category, is_active, published_at, meta_title, meta_description
- **Reuse:** `Admin/BlogController`, `Blog`, `BlogCategory` models, all blog views
- **Admin menu:** Blog

---

### 8. Pages (Static) ✅
- CMS pages for custom static content (privacy, terms, etc.)
- Fields: title, slug, content, meta_title, meta_description, is_active
- **Reuse:** `Admin/PageController`, `Page` model
- **Admin menu:** Pages

---

### 9. FAQs ✅
- Sortable FAQ list
- Fields: question, answer, is_active, sort_order
- **Reuse:** `Admin/FaqController`, `Faq` model
- **Admin menu:** FAQs

---

### 10. Contact Inquiries ✅
- View form submissions from the contact page
- Fields: name, email, phone, message, is_read, created_at
- **Reuse:** `Admin/ContactController`, `ContactInquiry` model
- **Admin menu:** Contact Inquiries

---

### 11. Newsletter Subscribers ✅
- View and export subscribers
- **Reuse:** `Admin/NewsletterController`, `NewsletterSubscriber` model
- **Admin menu:** Newsletter

---

### 12. Media Library ✅
- Upload images, browse, pick for other modules
- **Reuse:** `Admin/MediaController`, `Media` model, `MediaService`
- **Admin menu:** Media

---

### 13. Site Settings 🔄
- Key-value settings for site name, phone, email, address, socials, map embed, footer text, etc.
- **Reuse:** `Admin/SettingController`, `SiteSetting` model, `setting()` helper
- **Update:** Add MDS-specific setting keys to the settings view form
- **Admin menu:** Settings

---

## Admin Menu Structure (CMS Version)

```
Dashboard
─────────────────
Content
  Banners
  Homepage Sections
  Services
  Testimonials
  Blog
  Pages
  FAQs
─────────────────
Customer
  Contact Inquiries
  Newsletter
─────────────────
Media
  Media Library
─────────────────
System
  Site Settings
```

---

## Frontend Routes Summary

| Route | Controller | View |
|---|---|---|
| `GET /` | `Frontend/HomeController@index` | `frontend/home/index` |
| `GET /about` | `Frontend/AboutController@index` | `frontend/about/index` |
| `GET /services` | `Frontend/ServiceController@index` | `frontend/services/index` |
| `GET /blog` | `Frontend/BlogController@index` | `frontend/blog/index` |
| `GET /blog/{slug}` | `Frontend/BlogController@show` | `frontend/blog/show` |
| `GET /contact` | `Frontend/ContactController@index` | `frontend/contact/index` |
| `POST /contact` | `Frontend/ContactController@store` | redirect back |
| `POST /newsletter/subscribe` | `Frontend/NewsletterController@subscribe` | redirect back |
| `GET /pages/{slug}` | `Frontend/PageController@show` | `frontend/pages/show` |
