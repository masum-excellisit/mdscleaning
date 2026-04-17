# 02 — Existing Project Analysis

## Laravel Version
**Laravel 11.x** (confirmed in `composer.json`)

---

## Folder Structure

```
app/
  Helpers/helpers.php          — setting(), format_price(), active_class(), cart_count()
  Http/
    Controllers/
      Admin/                   — 19 admin controllers
      Auth/                    — Login, Register, ForgotPassword, ResetPassword
      Frontend/                — HomeController, AboutController, BlogController, etc.
    Middleware/
      AdminMiddleware.php      — role-based guard (super-admin, admin, manager, content-editor)
  Models/                      — 25 models
  Services/
    MediaService.php           — upload + resize + library record
    SlugService.php            — slug generation
    CartService.php            — e-commerce (ignore)
    InventoryService.php       — e-commerce (ignore)
    OrderService.php           — e-commerce (ignore)

resources/views/
  layouts/
    admin.blade.php            — full admin shell (sidebar + topbar + content)
    admin-auth.blade.php       — admin login shell
    app.blade.php              — frontend shell (currently e-commerce)
    auth.blade.php             — customer auth shell
  admin/                       — blade files per module (banners, blogs, pages, faqs, …)
  frontend/                    — home, about, blog, contact, shop, cart, etc.
  partials/                    — shared blade partials

routes/web.php                 — all routes in one file (frontend + auth + admin groups)
database/migrations/           — 33 migration files
```

---

## Reusable Modules

### Auth & Security
| Module | Files | Reuse |
|---|---|---|
| Admin login | `Auth/LoginController@showAdminLoginForm`, `adminLogin` | Full reuse |
| Admin middleware | `AdminMiddleware.php` | Full reuse |
| Spatie roles | `2026_04_13_…_create_permission_tables.php` | Full reuse |
| Password reset | `ForgotPasswordController`, `ResetPasswordController` | Full reuse |

### Admin Panel
| Module | Controller | View folder | Reuse |
|---|---|---|---|
| Dashboard | `DashboardController` | `admin/dashboard` | Full reuse |
| Banners | `BannerController` | `admin/banners` | Full reuse |
| Homepage Sections | `HomepageSectionController` | `admin/homepage-sections` | Full reuse |
| Pages (static) | `PageController` | `admin/pages` | Full reuse |
| Blogs | `BlogController` | `admin/blogs` | Full reuse |
| Blog Categories | (in BlogController) | `admin/blog-categories` | Full reuse |
| FAQs | `FaqController` | `admin/faqs` | Full reuse |
| Contact Inquiries | `ContactController` | `admin/contacts` | Full reuse |
| Newsletter | `NewsletterController` | `admin/newsletter` | Full reuse |
| Media Library | `MediaController` | `admin/media` | Full reuse |
| Settings | `SettingController` | `admin/settings` | Full reuse |

### Models
| Model | Table | Reuse |
|---|---|---|
| `SiteSetting` | `site_settings` | Full reuse |
| `Banner` | `banners` | Full reuse |
| `HomepageSection` | `homepage_sections` | Full reuse |
| `Blog` | `blogs` | Full reuse |
| `BlogCategory` | `blog_categories` | Full reuse |
| `Page` | `pages` | Full reuse |
| `Faq` | `faqs` | Full reuse |
| `ContactInquiry` | `contact_inquiries` | Full reuse |
| `NewsletterSubscriber` | `newsletter_subscribers` | Full reuse |
| `Media` | `media` | Full reuse |
| `User` | `users` | Full reuse |

### Services & Helpers
| Component | Reuse |
|---|---|
| `MediaService::store()` | Full reuse for all image uploads |
| `SlugService` | Full reuse |
| `setting()` helper | Full reuse across blade and controllers |
| `active_class()` helper | Full reuse in blade nav |

---

## E-commerce Modules — DELETE

All e-commerce-specific files must be deleted. The Frontend controllers directory is already empty.

### Admin Controllers to Delete
```
app/Http/Controllers/Admin/AttributeController.php
app/Http/Controllers/Admin/CategoryController.php
app/Http/Controllers/Admin/CollectionController.php
app/Http/Controllers/Admin/CouponController.php
app/Http/Controllers/Admin/CustomerController.php
app/Http/Controllers/Admin/InventoryController.php
app/Http/Controllers/Admin/OrderController.php
app/Http/Controllers/Admin/ProductController.php
```

### Models to Delete
```
app/Models/Address.php
app/Models/Attribute.php
app/Models/AttributeValue.php
app/Models/Cart.php
app/Models/CartItem.php
app/Models/Category.php
app/Models/Collection.php
app/Models/Coupon.php
app/Models/Inventory.php
app/Models/Order.php
app/Models/OrderAddress.php
app/Models/OrderItem.php
app/Models/Payment.php
app/Models/Product.php
app/Models/ProductImage.php
app/Models/ProductVariant.php
app/Models/ProductVariantAttribute.php
app/Models/Wishlist.php
```

### Services to Delete
```
app/Services/CartService.php
app/Services/InventoryService.php
app/Services/OrderService.php
```

### Request Classes to Delete
```
app/Http/Requests/CheckoutRequest.php
```

### Admin View Folders to Delete
```
resources/views/admin/attributes/
resources/views/admin/categories/
resources/views/admin/collections/
resources/views/admin/coupons/
resources/views/admin/customers/
resources/views/admin/inventory/
resources/views/admin/orders/
resources/views/admin/products/
```

### Frontend View Folders to Delete
```
resources/views/frontend/account/
resources/views/frontend/cart/
resources/views/frontend/checkout/
resources/views/frontend/collections/
resources/views/frontend/product/
resources/views/frontend/sellers/
resources/views/frontend/shop/
resources/views/frontend/wishlist/
```

### Database Tables to Drop
Do NOT delete the old migration files — they track schema history.
Instead, create a new migration: `drop_ecommerce_tables`.

Tables to drop (in dependency order):
```
payments
order_addresses
order_items
orders
wishlists
cart_items
carts
coupons
inventories
product_variant_attributes
product_variants
product_images
products
attribute_values
attributes
collections
categories
addresses
```

### Routes to Remove from web.php
All routes referencing deleted controllers:
- Shop, product, collections frontend routes
- Cart routes
- Checkout routes
- Account/wishlist routes
- All admin routes: products, categories, collections, attributes, inventory, orders, customers, coupons

---

## Admin Sidebar — Current vs CMS Target

### Remove from sidebar (delete the lines, not just hide):
- Products, Categories, Collections, Attributes
- Inventory, Orders, Customers, Coupons

### Keep / Add to sidebar:
- Dashboard
- Banners
- Homepage Sections
- Services *(new)*
- Testimonials *(new)*
- Blogs
- Pages
- FAQs
- Gallery / Media
- Contact Inquiries
- Newsletter
- Site Settings

---

## Key Patterns to Follow

| Pattern | Example |
|---|---|
| Controller constructor DI | `__construct(protected MediaService $media)` |
| Image upload | `$this->media->store($file, 'banners', [1200, 600])` |
| Status toggle | `POST /admin/banners/{id}/toggle` → `toggleStatus()` |
| Sort order | `POST /admin/banners/sort` → `updateSort()` |
| Settings read | `setting('site_name', 'Default')` |
| Settings write | `SiteSetting::set('key', 'value')` |
| Active scope | `Banner::active()->forPage('home')->orderBy('sort_order')->get()` |

---

## Risk / Conflict Areas

| Risk | Mitigation |
|---|---|
| `app.blade.php` is e-commerce themed | Create new `resources/views/layouts/website.blade.php` for MDS frontend |
| `Frontend/HomeController` imports e-commerce models | Rewrite only the controller method, keep file structure |
| `web.php` has shop/cart/checkout routes | Keep them; just don't link to them from MDS frontend nav |
| Spatie roles seeder may not have run | Run `php artisan db:seed` or create roles in settings |
| `site_name` setting shows "Cstees" | Seed correct MDS values in settings |
