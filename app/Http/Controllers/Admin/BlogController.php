<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Services\MediaService;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function __construct(
        protected SlugService $slug,
        protected MediaService $media,
    ) {}

    /* ----------------------------------------------------------
     | Posts
     |----------------------------------------------------------*/

    public function index(Request $request): View
    {
        $q = Blog::with(['author:id,name', 'category:id,name']);

        if ($s = $request->string('q')->toString()) {
            $q->where('title', 'like', "%{$s}%");
        }
        if ($cat = $request->integer('category')) {
            $q->where('blog_category_id', $cat);
        }
        if ($status = $request->string('status')->toString()) {
            $q->where('is_published', $status === 'published');
        }

        $blogs      = $q->latest()->paginate(config('cstees.pagination.admin_table', 20))->withQueryString();
        $categories = BlogCategory::orderBy('name')->get();

        return view('admin.blogs.index', compact('blogs', 'categories'));
    }

    public function create(): View
    {
        $blog = new Blog(['is_published' => false]);
        $categories = BlogCategory::orderBy('name')->get();
        return view('admin.blogs.create', compact('blog', 'categories'));
    }

    public function edit(int $id): View
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('name')->get();
        return view('admin.blogs.create', compact('blog', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->save($request, new Blog());
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return $this->save($request, Blog::findOrFail($id));
    }

    protected function save(Request $request, Blog $blog): RedirectResponse
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', Rule::unique('blogs', 'slug')->ignore($blog->id)],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'body'             => ['required', 'string'],
            'image'            => ['nullable', 'image', 'max:4096'],
            'remove_image'     => ['nullable', 'boolean'],
            'blog_category_id' => ['nullable', 'integer', 'exists:blog_categories,id'],
            'is_published'     => ['nullable', 'boolean'],
            'published_at'     => ['nullable', 'date'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        $blog->fill([
            'title'            => $data['title'],
            'excerpt'          => $data['excerpt'] ?? null,
            'body'             => $data['body'],
            'blog_category_id' => $data['blog_category_id'] ?? null,
            'is_published'     => (bool) ($data['is_published'] ?? false),
            'published_at'     => $data['published_at'] ?? ($blog->published_at ?? ($data['is_published'] ?? false ? now() : null)),
            'meta_title'       => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
        ]);

        if (! $blog->author_id) {
            $blog->author_id = auth()->id();
        }

        if (! $blog->slug || ! empty($data['slug'])) {
            $blog->slug = $this->slug->generate(Blog::class, $data['slug'] ?: $data['title'], 'slug', $blog->id);
        }

        if ($request->boolean('remove_image') && $blog->image) {
            $this->media->delete($blog->image);
            $blog->image = null;
        }
        if ($request->hasFile('image')) {
            if ($blog->image) $this->media->delete($blog->image);
            $blog->image = $this->media->store($request->file('image'), 'blogs', config('cstees.media.blog_resize'));
        }

        $blog->save();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post saved.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $blog = Blog::findOrFail($id);
        if ($blog->image) $this->media->delete($blog->image);
        $blog->delete();

        return back()->with('success', 'Post deleted.');
    }

    /* ----------------------------------------------------------
     | Categories
     |----------------------------------------------------------*/

    public function categoriesIndex(): View
    {
        $categories = BlogCategory::withCount('blogs')->orderBy('name')->get();
        return view('admin.blog-categories.index', compact('categories'));
    }

    public function categoriesStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        BlogCategory::create([
            'name' => $data['name'],
            'slug' => $this->slug->generate(BlogCategory::class, $data['name']),
        ]);

        return back()->with('success', 'Blog category added.');
    }

    public function categoriesDestroy(int $id): RedirectResponse
    {
        $category = BlogCategory::withCount('blogs')->findOrFail($id);
        if ($category->blogs_count > 0) {
            return back()->with('error', "Cannot delete: {$category->blogs_count} post(s) in this category.");
        }
        $category->delete();
        return back()->with('success', 'Blog category removed.');
    }
}
