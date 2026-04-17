<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageController extends Controller
{
    /** Slugs of pages that cannot be deleted. */
    protected array $protectedSlugs = ['about', 'contact', 'privacy-policy', 'terms', 'shipping-policy', 'returns'];

    public function __construct(protected SlugService $slug) {}

    public function index(Request $request): View
    {
        $q = Page::query();
        if ($s = $request->string('q')->toString()) {
            $q->where('title', 'like', "%{$s}%")->orWhere('slug', 'like', "%{$s}%");
        }
        $pages = $q->orderBy('title')->paginate(config('cstees.pagination.admin_table', 20))->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        $page = new Page(['is_active' => true]);
        return view('admin.pages.create', compact('page'));
    }

    public function edit(int $id): View
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.create', compact('page'));
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->save($request, new Page());
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return $this->save($request, Page::findOrFail($id));
    }

    protected function save(Request $request, Page $page): RedirectResponse
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($page->id)],
            'body'             => ['required', 'string'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_active'        => ['nullable', 'boolean'],
        ]);

        $page->fill([
            'title'            => $data['title'],
            'body'             => $data['body'],
            'meta_title'       => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'is_active'        => (bool) ($data['is_active'] ?? false),
        ]);

        if (! $page->slug || ! empty($data['slug'])) {
            $page->slug = $this->slug->generate(Page::class, $data['slug'] ?: $data['title'], 'slug', $page->id);
        }

        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Page saved.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $page = Page::findOrFail($id);
        if (in_array($page->slug, $this->protectedSlugs)) {
            return back()->with('error', "The \"{$page->title}\" page is protected and cannot be deleted.");
        }
        $page->delete();

        return back()->with('success', 'Page deleted.');
    }
}
