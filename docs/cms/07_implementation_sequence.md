# 07 — Implementation Sequence

## Guiding Principle
Build bottom-up: database → models → controllers → views → frontend. Test each phase before moving on.

---

## Phase 0 — E-commerce Cleanup (Do First)

**Goal:** Strip all e-commerce code so the project is a clean CMS base.

> **Before running migrate:** check `php artisan migrate:status`
> - If no migrations have run yet → delete the 18 migration files + delete tables won't exist yet
> - If migrations have already run → keep migration files, create a drop migration instead

### Step 0a — Delete Migration Files (if DB is fresh / never migrated)
Delete files `000003` through `000020` from `database/migrations/`.
Keep: `000001` (users), `000021`–`000032` (CMS tables), `permission_tables`.

### Step 0b — Drop Tables (if DB was already migrated)
Create new migration: `php artisan make:migration drop_ecommerce_tables`

```php
public function up(): void
{
    $tables = [
        'payments', 'order_addresses', 'order_items', 'orders',
        'wishlists', 'cart_items', 'carts', 'coupons', 'inventories',
        'product_variant_attributes', 'product_variants', 'product_images',
        'products', 'attribute_values', 'attributes',
        'collections', 'categories', 'addresses',
    ];
    foreach ($tables as $table) {
        Schema::dropIfExists($table);
    }
}
public function down(): void {} // intentionally empty — no rollback
```

Then run: `php artisan migrate`

### Step 0c — Delete Admin Controllers
```bash
rm app/Http/Controllers/Admin/AttributeController.php
rm app/Http/Controllers/Admin/CategoryController.php
rm app/Http/Controllers/Admin/CollectionController.php
rm app/Http/Controllers/Admin/CouponController.php
rm app/Http/Controllers/Admin/CustomerController.php
rm app/Http/Controllers/Admin/InventoryController.php
rm app/Http/Controllers/Admin/OrderController.php
rm app/Http/Controllers/Admin/ProductController.php
```

### Step 0d — Delete Models
```bash
rm app/Models/Address.php app/Models/Attribute.php app/Models/AttributeValue.php
rm app/Models/Cart.php app/Models/CartItem.php app/Models/Category.php
rm app/Models/Collection.php app/Models/Coupon.php app/Models/Inventory.php
rm app/Models/Order.php app/Models/OrderAddress.php app/Models/OrderItem.php
rm app/Models/Payment.php app/Models/Product.php app/Models/ProductImage.php
rm app/Models/ProductVariant.php app/Models/ProductVariantAttribute.php
rm app/Models/Wishlist.php
```

### Step 0e — Delete Services & Requests
```bash
rm app/Services/CartService.php
rm app/Services/InventoryService.php
rm app/Services/OrderService.php
rm app/Http/Requests/CheckoutRequest.php
```

### Step 0f — Delete Admin Views
```bash
rm -rf resources/views/admin/attributes
rm -rf resources/views/admin/categories
rm -rf resources/views/admin/collections
rm -rf resources/views/admin/coupons
rm -rf resources/views/admin/customers
rm -rf resources/views/admin/inventory
rm -rf resources/views/admin/orders
rm -rf resources/views/admin/products
```

### Step 0g — Delete Frontend Views
```bash
rm -rf resources/views/frontend/account
rm -rf resources/views/frontend/cart
rm -rf resources/views/frontend/checkout
rm -rf resources/views/frontend/collections
rm -rf resources/views/frontend/product
rm -rf resources/views/frontend/sellers
rm -rf resources/views/frontend/shop
rm -rf resources/views/frontend/wishlist
```

### Step 0h — Clean up web.php
Remove all `use` import lines for deleted controllers.
Remove all route blocks for: shop, product, collections, cart, checkout, wishlist, account, sellers.
Remove all admin route blocks for: products, categories, collections, attributes, inventory, orders, customers, coupons.

Keep: auth routes, admin routes for CMS modules, home/about/blog/contact/pages/newsletter frontend routes.

### Step 0i — Verify
```bash
php artisan route:list          # should show no errors
php artisan config:clear
php artisan cache:clear
```

**Deliverable:** Project boots cleanly. No references to deleted files. `php artisan route:list` shows no errors.

---

## Phase 1 — Foundation Setup

**Goal:** Get the existing project running with MDS branding. No new features yet.

### Steps
1. Copy `html-source/style.css` → `public/assets/css/website.css`
2. Copy all `html-source/assets/*` → `public/assets/images/`
3. Run existing migrations: `php artisan migrate`
4. Seed Spatie roles if not done: create `super-admin` role, assign to admin user
5. Update `site_settings` rows: set `site_name = MDS Cleaning`, `phone`, `email`, etc.
6. Verify admin login works at `/admin/login`

**Deliverable:** Admin panel accessible, MDS assets in public folder.

---

## Phase 2 — New Migrations & Models

**Goal:** Create DB tables for Services and Testimonials.

### Steps
1. Create migration `create_services_table` (see schema in `05_database_schema_plan.md`)
2. Create migration `create_testimonials_table`
3. Run: `php artisan migrate`
4. Create `app/Models/Service.php` — fillable, casts, scopes (active, sort)
5. Create `app/Models/Testimonial.php` — fillable, casts, scopes

**Deliverable:** Tables exist, models ready.

---

## Phase 3 — Admin CRUD: Services

**Goal:** Admin can add/edit/delete services.

### Steps
1. Create `app/Http/Controllers/Admin/ServiceController.php`
   - Copy pattern from `BannerController` (has `MediaService` DI, image upload, toggle)
2. Create `resources/views/admin/services/index.blade.php` (copy table pattern from `admin/banners/index`)
3. Create `resources/views/admin/services/create.blade.php` (copy form pattern from `admin/banners/create`)
4. Add routes to `web.php` admin group
5. Add "Services" link to admin sidebar in `layouts/admin.blade.php`
6. Test: create 3 services matching the HTML design content

**Deliverable:** Admin can manage services. Sidebar has Services link.

---

## Phase 4 — Admin CRUD: Testimonials

**Goal:** Admin can add/edit/delete testimonials.

### Steps
1. Create `app/Http/Controllers/Admin/TestimonialController.php`
2. Create `resources/views/admin/testimonials/index.blade.php`
3. Create `resources/views/admin/testimonials/create.blade.php`
4. Add routes to `web.php` admin group
5. Add "Testimonials" link to admin sidebar
6. Test: add 3 testimonials

**Deliverable:** Admin can manage testimonials.

---

## Phase 5 — Admin Sidebar Cleanup

**Goal:** CMS-focused sidebar. E-commerce links removed.

### Steps
1. Edit `resources/views/layouts/admin.blade.php`
2. **Delete** sidebar `<a>` lines for: Products, Categories, Collections, Attributes, Inventory, Orders, Customers, Coupons (not just hide — delete them, the controllers are gone)
3. Add: Services, Testimonials links
4. Reorder sections per `04_cms_module_plan.md`

**Deliverable:** Admin sidebar shows only CMS modules.

---

## Phase 6 — Frontend Layout & Partials

**Goal:** Create the MDS Blade layout and shared partials.

### Steps
1. Create `resources/views/layouts/website.blade.php`
   - Head with Google Fonts, Bootstrap 5 CDN, BI CDN, `website.css`
   - `@include('partials.website.topstrip')`
   - `@include('partials.website.header')`
   - `@yield('content')`
   - `@include('partials.website.footer')`
   - Scripts: Bootstrap JS CDN, `@stack('scripts')`
2. Create `resources/views/partials/website/topstrip.blade.php` from `index.html` top strip
3. Create `resources/views/partials/website/header.blade.php` from `index.html` header
4. Create `resources/views/partials/website/footer.blade.php` from `index.html` footer

**Deliverable:** Layout renders correctly on a test route.

---

## Phase 7 — Frontend Home Page

**Goal:** Home page fully dynamic.

### Steps
1. Update `Frontend/HomeController@index` — load: banners, homepage_sections, services, testimonials
2. Create `resources/views/frontend/home/index.blade.php` from `index.html`
   - `@extends('layouts.website')`
   - Map each section to its dynamic data (see `03_html_to_blade_mapping.md`)
3. Test with browser

**Deliverable:** Home page renders with admin-managed content.

---

## Phase 8 — Frontend About Page

### Steps
1. Update `Frontend/AboutController@index` — load homepage_sections for about keys
2. Create `resources/views/frontend/about/index.blade.php` from `about.html`
3. Test

---

## Phase 9 — Frontend Services Page

### Steps
1. Create `Frontend/ServiceController.php` (or update `AboutController`) — load `Service::active()`
2. Add route `GET /services`
3. Create `resources/views/frontend/services/index.blade.php` from `services.html`
4. Test

---

## Phase 10 — Frontend Contact Page

### Steps
1. Update `Frontend/ContactController@index` — pass setting values
2. Update `Frontend/ContactController@store` — already handles `ContactInquiry` storage (verify it works)
3. Create `resources/views/frontend/contact/index.blade.php` from `contact.html`
4. Test form submission → check `/admin/contacts`

---

## Phase 11 — Settings & SEO

### Steps
1. Update `Admin/SettingController` view to include MDS-specific fields (phone, email, address, socials, announcement, map embed URL)
2. Add `<title>@yield('meta_title', setting('meta_title', 'MDS Cleaning'))</title>` to `website.blade.php`
3. Add meta description to layout
4. Test settings save → frontend reflects changes

---

## Phase 12 — Seed Content

### Steps
1. Seed `site_settings` with MDS defaults
2. Seed `homepage_sections` with the required section keys and placeholder content
3. Add 3 sample services from the HTML design
4. Add 3 sample testimonials

---

## Phase 13 — Final Cleanup & Testing

See `10_testing_checklist.md`

---

## Module Build Order Summary

```
0. CLEANUP — delete e-commerce controllers, models, services, views, routes, tables
1. Assets + run CMS migrations
2. Models: Service, Testimonial (new)
3. Admin: Services CRUD
4. Admin: Testimonials CRUD
5. Admin: Sidebar — remove e-commerce links, add CMS links
6. Frontend: Layout + partials
7. Frontend: Home page
8. Frontend: About page
9. Frontend: Services page
10. Frontend: Contact page
11. Settings: MDS keys
12. Seed content
13. Test + cleanup
```
