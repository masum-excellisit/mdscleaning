<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $hero       = HomepageSection::get('about_hero');
        $story      = HomepageSection::get('about_story');
        $why        = HomepageSection::get('about_why');
        $details    = HomepageSection::get('about_details');
        $ctaAbout   = HomepageSection::get('cta_about');

        return view('frontend.about.index', compact('hero', 'story', 'why', 'details', 'ctaAbout'));
    }
}
