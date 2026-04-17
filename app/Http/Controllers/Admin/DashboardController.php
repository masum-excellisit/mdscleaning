<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\ContactInquiry;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalServices     = Service::count();
        $activeServices    = Service::where('is_active', true)->count();
        $totalTestimonials = Testimonial::count();
        $totalBlogs        = Blog::count();
        $publishedBlogs    = Blog::published()->count();
        $totalBanners      = Banner::count();

        $unreadInquiries = ContactInquiry::where('is_read', false)->latest()->limit(5)->get();
        $totalInquiries  = ContactInquiry::count();
        $newInquiries    = ContactInquiry::where('is_read', false)->count();

        $recentInquiries = ContactInquiry::latest()->limit(10)->get();

        return view('admin.dashboard.index', compact(
            'totalServices',
            'activeServices',
            'totalTestimonials',
            'totalBlogs',
            'publishedBlogs',
            'totalBanners',
            'unreadInquiries',
            'totalInquiries',
            'newInquiries',
            'recentInquiries'
        ));
    }
}
