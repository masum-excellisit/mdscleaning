<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\HomepageSection;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $banners      = Banner::active()->forPage('home')->orderBy('sort_order')->get();
        $intro        = HomepageSection::get('intro');
        $whyChoose    = HomepageSection::get('why_choose');
        $cta          = HomepageSection::get('cta');
        $clients      = HomepageSection::get('clients');
        $services     = Service::active()->orderBy('sort_order')->get();
        $testimonials = Testimonial::active()->orderBy('sort_order')->get();

        return view('frontend.home.index', compact(
            'banners', 'intro', 'whyChoose', 'cta', 'clients', 'services', 'testimonials'
        ));
    }
}
