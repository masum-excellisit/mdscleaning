<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email|max:200']);

        NewsletterSubscriber::firstOrCreate(['email' => $request->email]);

        return back()->with('success', 'You have been subscribed!');
    }
}
