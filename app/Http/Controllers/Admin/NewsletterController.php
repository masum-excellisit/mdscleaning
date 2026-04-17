<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function index(Request $request): View
    {
        $q = NewsletterSubscriber::query();

        if ($s = $request->string('q')->toString()) {
            $q->where('email', 'like', "%{$s}%");
        }
        if ($status = $request->string('status')->toString()) {
            $q->where('is_active', $status === 'active');
        }

        $subscribers = $q->latest('subscribed_at')->paginate(50)->withQueryString();

        $stats = [
            'total'    => NewsletterSubscriber::count(),
            'active'   => NewsletterSubscriber::where('is_active', true)->count(),
            'inactive' => NewsletterSubscriber::where('is_active', false)->count(),
            'last_30'  => NewsletterSubscriber::where('subscribed_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin.newsletter.index', compact('subscribers', 'stats'));
    }

    public function destroy(int $id): RedirectResponse
    {
        NewsletterSubscriber::findOrFail($id)->delete();
        return back()->with('success', 'Subscriber removed.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids'   => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:newsletter_subscribers,id'],
        ]);

        $count = NewsletterSubscriber::whereIn('id', $data['ids'])->delete();
        return back()->with('success', "{$count} subscriber(s) removed.");
    }

    public function export(): StreamedResponse
    {
        $filename = 'newsletter-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Email', 'Active', 'Subscribed At']);
            NewsletterSubscriber::orderBy('subscribed_at')->chunk(500, function ($chunk) use ($out) {
                foreach ($chunk as $sub) {
                    fputcsv($out, [
                        $sub->email,
                        $sub->is_active ? 'yes' : 'no',
                        $sub->subscribed_at?->toIso8601String(),
                    ]);
                }
            });
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
