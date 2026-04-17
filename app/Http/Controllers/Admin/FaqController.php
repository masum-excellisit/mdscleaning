<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        $editFaq = $request->filled('edit') ? Faq::find($request->integer('edit')) : null;
        $faqs    = Faq::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.faqs.index', compact('faqs', 'editFaq'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'question'   => ['required', 'string', 'max:500'],
            'answer'     => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        Faq::create([
            'question'   => $data['question'],
            'answer'     => $data['answer'],
            'sort_order' => (int) ($data['sort_order'] ?? (Faq::max('sort_order') ?? 0) + 1),
            'is_active'  => (bool) ($data['is_active'] ?? true),
        ]);

        return back()->with('success', 'FAQ added.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $faq = Faq::findOrFail($id);
        $data = $request->validate([
            'question'   => ['required', 'string', 'max:500'],
            'answer'     => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $faq->update([
            'question'   => $data['question'],
            'answer'     => $data['answer'],
            'sort_order' => (int) ($data['sort_order'] ?? $faq->sort_order),
            'is_active'  => (bool) ($data['is_active'] ?? false),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Faq::findOrFail($id)->delete();
        return back()->with('success', 'FAQ removed.');
    }

    public function updateSort(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order'   => ['required', 'array'],
            'order.*' => ['integer', 'exists:faqs,id'],
        ]);

        foreach ($data['order'] as $position => $id) {
            Faq::where('id', $id)->update(['sort_order' => $position]);
        }

        return response()->json(['ok' => true]);
    }
}
