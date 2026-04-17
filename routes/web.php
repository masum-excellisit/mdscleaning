<?php

use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\HomepageSectionController as AdminHomepageSectionController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

/*
|--------------------------------------------------------------------------
| Auth Routes (guest only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/login', [LoginController::class, 'showAdminLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'adminLogin'])->name('login.submit');
    });

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendLink'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'update'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes (prefix /admin, name admin.*, middleware admin)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['admin'])
    ->group(function () {

        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Banners
        Route::get('/banners', [AdminBannerController::class, 'index'])->name('banners.index');
        Route::get('/banners/create', [AdminBannerController::class, 'create'])->name('banners.create');
        Route::post('/banners', [AdminBannerController::class, 'store'])->name('banners.store');
        Route::get('/banners/{id}/edit', [AdminBannerController::class, 'edit'])->name('banners.edit');
        Route::put('/banners/{id}', [AdminBannerController::class, 'update'])->name('banners.update');
        Route::delete('/banners/{id}', [AdminBannerController::class, 'destroy'])->name('banners.destroy');
        Route::post('/banners/sort', [AdminBannerController::class, 'updateSort'])->name('banners.sort');

        // Homepage Sections
        Route::get('/homepage-sections', [AdminHomepageSectionController::class, 'index'])->name('homepage-sections.index');
        Route::get('/homepage-sections/{id}/edit', [AdminHomepageSectionController::class, 'edit'])->name('homepage-sections.edit');
        Route::put('/homepage-sections/{id}', [AdminHomepageSectionController::class, 'update'])->name('homepage-sections.update');
        Route::post('/homepage-sections/{id}/toggle', [AdminHomepageSectionController::class, 'toggle'])->name('homepage-sections.toggle');

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

        // Blogs
        Route::get('/blogs', [AdminBlogController::class, 'index'])->name('blogs.index');
        Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('blogs.create');
        Route::post('/blogs', [AdminBlogController::class, 'store'])->name('blogs.store');
        Route::get('/blogs/{id}/edit', [AdminBlogController::class, 'edit'])->name('blogs.edit');
        Route::put('/blogs/{id}', [AdminBlogController::class, 'update'])->name('blogs.update');
        Route::delete('/blogs/{id}', [AdminBlogController::class, 'destroy'])->name('blogs.destroy');

        // Blog Categories
        Route::get('/blog-categories', [AdminBlogController::class, 'categoriesIndex'])->name('blog-categories.index');
        Route::post('/blog-categories', [AdminBlogController::class, 'categoriesStore'])->name('blog-categories.store');
        Route::delete('/blog-categories/{id}', [AdminBlogController::class, 'categoriesDestroy'])->name('blog-categories.destroy');

        // Pages
        Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
        Route::get('/pages/create', [AdminPageController::class, 'create'])->name('pages.create');
        Route::post('/pages', [AdminPageController::class, 'store'])->name('pages.store');
        Route::get('/pages/{id}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{id}', [AdminPageController::class, 'update'])->name('pages.update');
        Route::delete('/pages/{id}', [AdminPageController::class, 'destroy'])->name('pages.destroy');

        // FAQs
        Route::get('/faqs', [AdminFaqController::class, 'index'])->name('faqs.index');
        Route::post('/faqs', [AdminFaqController::class, 'store'])->name('faqs.store');
        Route::put('/faqs/{id}', [AdminFaqController::class, 'update'])->name('faqs.update');
        Route::delete('/faqs/{id}', [AdminFaqController::class, 'destroy'])->name('faqs.destroy');
        Route::post('/faqs/sort', [AdminFaqController::class, 'updateSort'])->name('faqs.sort');

        // Newsletter
        Route::get('/newsletter', [AdminNewsletterController::class, 'index'])->name('newsletter.index');
        Route::delete('/newsletter/{id}', [AdminNewsletterController::class, 'destroy'])->name('newsletter.destroy');
        Route::post('/newsletter/bulk', [AdminNewsletterController::class, 'bulkDelete'])->name('newsletter.bulk');
        Route::get('/newsletter/export', [AdminNewsletterController::class, 'export'])->name('newsletter.export');

        // Contacts
        Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{id}', [AdminContactController::class, 'show'])->name('contacts.show');
        Route::post('/contacts/{id}/read', [AdminContactController::class, 'markRead'])->name('contacts.read');
        Route::delete('/contacts/{id}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

        // Media
        Route::get('/media', [AdminMediaController::class, 'index'])->name('media.index');
        Route::post('/media/upload', [AdminMediaController::class, 'upload'])->name('media.upload');
        Route::delete('/media/{id}', [AdminMediaController::class, 'destroy'])->name('media.destroy');
        Route::get('/media/picker', [AdminMediaController::class, 'picker'])->name('media.picker');

        // Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
