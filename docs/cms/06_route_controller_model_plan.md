# 06 — Route / Controller / Model Plan

## Status Legend
- ✅ Reuse existing, no changes
- 🔄 Update existing file
- 🆕 Create new file
- 🗑️ Delete

---

## Files to DELETE (E-commerce Cleanup)

### Admin Controllers
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

### Models
```
app/Models/Address.php          app/Models/Attribute.php
app/Models/AttributeValue.php   app/Models/Cart.php
app/Models/CartItem.php         app/Models/Category.php
app/Models/Collection.php       app/Models/Coupon.php
app/Models/Inventory.php        app/Models/Order.php
app/Models/OrderAddress.php     app/Models/OrderItem.php
app/Models/Payment.php          app/Models/Product.php
app/Models/ProductImage.php     app/Models/ProductVariant.php
app/Models/ProductVariantAttribute.php
app/Models/Wishlist.php
```

### Services
```
app/Services/CartService.php
app/Services/InventoryService.php
app/Services/OrderService.php
```

### Requests
```
app/Http/Requests/CheckoutRequest.php
```

### Admin Views
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

### Frontend Views
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

### Migration Files to Delete
> Safe to delete migration FILES only if the DB has never been migrated.
> If migrations have already run, **do not delete files** — create a drop migration instead.

E-commerce migration files (000003 through 000020):
```
2024_01_01_000003_create_addresses_table.php
2024_01_01_000004_create_categories_table.php
2024_01_01_000005_create_collections_table.php
2024_01_01_000006_create_products_table.php
2024_01_01_000007_create_product_images_table.php
2024_01_01_000008_create_attributes_table.php
2024_01_01_000009_create_attribute_values_table.php
2024_01_01_000010_create_product_variants_table.php
2024_01_01_000011_create_product_variant_attributes_table.php
2024_01_01_000012_create_inventories_table.php
2024_01_01_000013_create_carts_table.php
2024_01_01_000014_create_cart_items_table.php
2024_01_01_000015_create_wishlists_table.php
2024_01_01_000016_create_coupons_table.php
2024_01_01_000017_create_orders_table.php
2024_01_01_000018_create_order_items_table.php
2024_01_01_000019_create_order_addresses_table.php
2024_01_01_000020_create_payments_table.php
```

### Routes to Remove from web.php
Remove all blocks referencing deleted controllers:
- `ShopController`, `ProductController`, `CollectionController` (frontend)
- `CartController`, `CheckoutController`, `WishlistController`
- `AccountController`, `SellerController`
- All `auth` customer routes (`/wishlist`, `/checkout`, `/account/…`)
- Admin routes: products, categories, collections, attributes, inventory, orders, customers, coupons

Also remove their `use` import lines at the top of `web.php`.

---

## Models

| Model | File | Status | Notes |
|---|---|---|---|
| `User` | `app/Models/User.php` | ✅ | |
| `SiteSetting` | `app/Models/SiteSetting.php` | ✅ | |
| `Banner` | `app/Models/Banner.php` | ✅ | |
| `HomepageSection` | `app/Models/HomepageSection.php` | ✅ | |
| `Blog` | `app/Models/Blog.php` | ✅ | |
| `BlogCategory` | `app/Models/BlogCategory.php` | ✅ | |
| `Page` | `app/Models/Page.php` | ✅ | |
| `Faq` | `app/Models/Faq.php` | ✅ | |
| `ContactInquiry` | `app/Models/ContactInquiry.php` | ✅ | |
| `NewsletterSubscriber` | `app/Models/NewsletterSubscriber.php` | ✅ | |
| `Media` | `app/Models/Media.php` | ✅ | |
| `Service` | `app/Models/Service.php` | 🆕 | |
| `Testimonial` | `app/Models/Testimonial.php` | 🆕 | |

---

## Admin Controllers

| Controller | File | Status | Key Methods |
|---|---|---|---|
| `DashboardController` | `Admin/DashboardController.php` | 🔄 | Add Service/Testimonial counts |
| `BannerController` | `Admin/BannerController.php` | ✅ | index, create, store, edit, update, destroy, sort |
| `HomepageSectionController` | `Admin/HomepageSectionController.php` | ✅ | index, edit, update, toggle |
| `ServiceController` | `Admin/ServiceController.php` | 🆕 | index, create, store, edit, update, destroy, toggle |
| `TestimonialController` | `Admin/TestimonialController.php` | 🆕 | index, create, store, edit, update, destroy, toggle |
| `BlogController` | `Admin/BlogController.php` | ✅ | |
| `PageController` | `Admin/PageController.php` | ✅ | |
| `FaqController` | `Admin/FaqController.php` | ✅ | |
| `ContactController` | `Admin/ContactController.php` | ✅ | |
| `NewsletterController` | `Admin/NewsletterController.php` | ✅ | |
| `MediaController` | `Admin/MediaController.php` | ✅ | |
| `SettingController` | `Admin/SettingController.php` | 🔄 | Add MDS setting keys to form |

---

## Frontend Controllers

| Controller | File | Status | Notes |
|---|---|---|---|
| `HomeController` | `Frontend/HomeController.php` | 🔄 | Replace e-commerce queries with CMS queries |
| `AboutController` | `Frontend/AboutController.php` | 🔄 | Load HomepageSections for about page |
| `ServiceController` | `Frontend/ServiceController.php` | 🆕 | Load services list |
| `BlogController` | `Frontend/BlogController.php` | ✅ | |
| `ContactController` | `Frontend/ContactController.php` | ✅ | index + store |
| `PageController` | `Frontend/PageController.php` | ✅ | |
| `NewsletterController` | `Frontend/NewsletterController.php` | ✅ | |

---

## Migrations

| File | Status |
|---|---|
| All existing 33 migrations | ✅ Run as-is |
| `create_services_table.php` | 🆕 New |
| `create_testimonials_table.php` | 🆕 New |

---

## Form Request Validation Classes

| Class | File | Status | Notes |
|---|---|---|---|
| `StoreServiceRequest` | `app/Http/Requests/StoreServiceRequest.php` | 🆕 | title required, image optional |
| `StoreTestimonialRequest` | `app/Http/Requests/StoreTestimonialRequest.php` | 🆕 | name, content required |

> Check if existing modules use inline `$request->validate()` — if so, follow that same pattern
> rather than creating Request classes, to stay consistent with the existing code style.

---

## Route Groups (web.php updates)

### Add to admin group:
```php
// Services
Route::get('/services', [AdminServiceController::class, 'index'])->name('services.index');
Route::get('/services/create', [AdminServiceController::class, 'create'])->name('services.create');
Route::post('/services', [AdminServiceController::class, 'store'])->name('services.store');
Route::get('/services/{id}/edit', [AdminServiceController::class, 'edit'])->name('services.edit');
Route::put('/services/{id}', [AdminServiceController::class, 'update'])->name('services.update');
Route::delete('/services/{id}', [AdminServiceController::class, 'destroy'])->name('services.destroy');
Route::post('/services/{id}/toggle', [AdminServiceController::class, 'toggle'])->name('services.toggle');

// Testimonials
Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
Route::get('/testimonials/create', [AdminTestimonialController::class, 'create'])->name('testimonials.create');
Route::post('/testimonials', [AdminTestimonialController::class, 'store'])->name('testimonials.store');
Route::get('/testimonials/{id}/edit', [AdminTestimonialController::class, 'edit'])->name('testimonials.edit');
Route::put('/testimonials/{id}', [AdminTestimonialController::class, 'update'])->name('testimonials.update');
Route::delete('/testimonials/{id}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');
Route::post('/testimonials/{id}/toggle', [AdminTestimonialController::class, 'toggle'])->name('testimonials.toggle');
```

### Add/Replace in frontend routes:
```php
Route::get('/services', [Frontend\ServiceController::class, 'index'])->name('services');
```

### Update existing:
```php
// Already exists — just update the controller method body:
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
```

---

## Views — New Files Needed

### Admin Views
| Path | Purpose |
|---|---|
| `resources/views/admin/services/index.blade.php` | Services list table |
| `resources/views/admin/services/create.blade.php` | Create/edit service form |
| `resources/views/admin/testimonials/index.blade.php` | Testimonials list table |
| `resources/views/admin/testimonials/create.blade.php` | Create/edit testimonial form |

### Frontend Views
| Path | Purpose |
|---|---|
| `resources/views/layouts/website.blade.php` | MDS frontend layout |
| `resources/views/partials/website/topstrip.blade.php` | Top announcement strip |
| `resources/views/partials/website/header.blade.php` | Site navigation header |
| `resources/views/partials/website/footer.blade.php` | Site footer |
| `resources/views/frontend/home/index.blade.php` | Home page |
| `resources/views/frontend/about/index.blade.php` | About page |
| `resources/views/frontend/services/index.blade.php` | Services page |
| `resources/views/frontend/contact/index.blade.php` | Contact page |
