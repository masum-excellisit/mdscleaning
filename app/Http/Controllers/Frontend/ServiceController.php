<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $hero         = HomepageSection::get('services_hero');
        $guarantees   = HomepageSection::get('service_guarantees');
        $ctaServices  = HomepageSection::get('cta_services');
        $services     = Service::active()->orderBy('sort_order')->get();

        return view('frontend.services.index', compact('hero', 'guarantees', 'ctaServices', 'services'));
    }
}
