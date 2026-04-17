<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $q = ContactInquiry::query();

        if ($s = $request->string('q')->toString()) {
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('subject', 'like', "%{$s}%");
            });
        }
        if ($status = $request->string('status')->toString()) {
            $q->where('is_read', $status === 'read');
        }

        $inquiries = $q->latest()->paginate(20)->withQueryString();

        $counts = [
            'all'    => ContactInquiry::count(),
            'unread' => ContactInquiry::where('is_read', false)->count(),
            'read'   => ContactInquiry::where('is_read', true)->count(),
        ];

        return view('admin.contacts.index', compact('inquiries', 'counts'));
    }

    public function show(int $id): View
    {
        $inquiry = ContactInquiry::findOrFail($id);

        if (! $inquiry->is_read) {
            $inquiry->update(['is_read' => true]);
        }

        return view('admin.contacts.show', compact('inquiry'));
    }

    public function markRead(int $id): RedirectResponse
    {
        $inquiry = ContactInquiry::findOrFail($id);
        $inquiry->update(['is_read' => ! $inquiry->is_read]);

        return back()->with('success', 'Marked as ' . ($inquiry->is_read ? 'read' : 'unread') . '.');
    }

    public function destroy(int $id): RedirectResponse
    {
        ContactInquiry::findOrFail($id)->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Inquiry deleted.');
    }
}
