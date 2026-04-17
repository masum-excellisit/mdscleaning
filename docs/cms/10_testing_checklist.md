# 10 — Testing Checklist

---

## Phase 1 — Admin Panel Baseline

- [ ] `/admin/login` loads correctly
- [ ] Admin can log in with valid credentials
- [ ] Invalid credentials show error message
- [ ] Admin dashboard loads without errors
- [ ] Sidebar shows only CMS modules (no Products/Orders/etc.)

---

## Phase 2 — Banners

- [ ] `/admin/banners` lists existing banners
- [ ] Can create a new banner with image upload
- [ ] Uploaded image appears in storage/app/public/banners/
- [ ] `Storage::url()` returns accessible URL
- [ ] Can edit banner title, subtitle, button
- [ ] Status toggle (active/inactive) works
- [ ] Sort order can be updated
- [ ] Can delete a banner
- [ ] Deleted banner image removed from storage

---

## Phase 3 — Homepage Sections

- [ ] `/admin/homepage-sections` lists all section keys
- [ ] Can edit `intro` section — title and content saved
- [ ] Can toggle section active/inactive
- [ ] `settings` JSON field saves and loads correctly
- [ ] All required section keys exist (intro, why_choose, cta, clients, about_hero, etc.)

---

## Phase 4 — Services (New Module)

- [ ] `/admin/services` loads without errors
- [ ] Can create service with: title, excerpt, description, icon_class, image, sort_order
- [ ] `features` JSON field accepts and stores multiple items
- [ ] Image uploads to `storage/app/public/services/`
- [ ] Can edit service
- [ ] Status toggle works
- [ ] Can delete service
- [ ] Sort order is respected in listing
- [ ] 3 services exist that match the HTML design content

---

## Phase 5 — Testimonials (New Module)

- [ ] `/admin/testimonials` loads without errors
- [ ] Can create testimonial with name, role, content, rating
- [ ] Optional avatar image uploads correctly
- [ ] Can edit testimonial
- [ ] Status toggle works
- [ ] Can delete testimonial
- [ ] Sort order respected

---

## Phase 6 — Blogs

- [ ] `/admin/blogs` lists blogs
- [ ] Can create blog post with image, category, published_at
- [ ] Slug auto-generates from title
- [ ] Blog category CRUD works
- [ ] Can publish/unpublish

---

## Phase 7 — FAQs

- [ ] `/admin/faqs` lists FAQs
- [ ] Can create/edit/delete FAQ
- [ ] Sort order drag or input works

---

## Phase 8 — Contact Inquiries

- [ ] `/admin/contacts` lists submissions
- [ ] Can mark as read
- [ ] Can view full inquiry details
- [ ] Can delete

---

## Phase 9 — Settings

- [ ] `/admin/settings` loads form
- [ ] Can save: site_name, phone, email, address, business_hours
- [ ] Can save social URLs
- [ ] Can save announcement_text
- [ ] Can save map_embed_url
- [ ] Changes reflected immediately on frontend (cache cleared)

---

## Phase 10 — Frontend Home Page

- [ ] `/` loads without errors
- [ ] Hero carousel shows active banners from DB
- [ ] Correct number of slides (matches active banners)
- [ ] Intro section text from DB
- [ ] Services section shows active services
- [ ] Testimonials section shows active testimonials
- [ ] CTA section from DB
- [ ] Page `<title>` uses `setting('meta_title')`
- [ ] No broken images
- [ ] Bootstrap carousel works (JS loaded)
- [ ] Page is responsive (mobile nav works)

---

## Phase 11 — Frontend About Page

- [ ] `/about` loads without errors
- [ ] Page hero shows correct title/subtitle from DB
- [ ] Story section shows content from DB
- [ ] Why section shows 4 numbered items from DB
- [ ] Detail cards render correctly
- [ ] No broken images

---

## Phase 12 — Frontend Services Page

- [ ] `/services` loads without errors
- [ ] Service cards render from DB
- [ ] Detailed service blocks render from DB
- [ ] Service icons render (Bootstrap Icons class)
- [ ] Guarantee section from DB

---

## Phase 13 — Frontend Contact Page

- [ ] `/contact` loads without errors
- [ ] Phone, email, hours from `site_settings`
- [ ] Contact form submits via POST
- [ ] CSRF token present
- [ ] Validation errors display on invalid submit
- [ ] Success message on valid submit
- [ ] Submission appears in `/admin/contacts`
- [ ] Map embed loads (if URL set)

---

## Phase 14 — Navigation & Footer

- [ ] Header logo loads
- [ ] Nav links work: Home, About, Services, Contact
- [ ] "Book Now" button links to contact page
- [ ] Mobile hamburger menu opens/closes
- [ ] Active nav item highlighted on current page
- [ ] Footer phone, email, address from settings
- [ ] Footer social links from settings
- [ ] Footer copyright year correct

---

## Phase 15 — Newsletter Subscription

- [ ] Newsletter form (if present on frontend) submits
- [ ] Submission appears in `/admin/newsletter`
- [ ] Duplicate email handled gracefully

---

## Phase 16 — Media Library

- [ ] `/admin/media` loads
- [ ] Can upload image
- [ ] Can delete image
- [ ] Media picker modal works when opened from banner/service form

---

## Phase 17 — SEO

- [ ] `<title>` tag on each page uses correct value
- [ ] `<meta name="description">` present on each page
- [ ] No duplicate title tags
- [ ] OG tags (optional but good to have)

---

## Phase 18 — Responsive / Visual

- [ ] Home page: desktop, tablet, mobile
- [ ] About page: desktop, tablet, mobile
- [ ] Services page: desktop, tablet, mobile
- [ ] Contact page: desktop, tablet, mobile
- [ ] No horizontal scroll on mobile
- [ ] Images not stretched or distorted

---

## Quick Smoke Test Commands

```bash
php artisan route:list --path=admin      # verify all admin routes registered
php artisan route:list --path=/          # verify frontend routes
php artisan migrate:status               # all migrations run
php artisan storage:link                 # public storage link exists
php artisan config:clear && php artisan cache:clear
```
