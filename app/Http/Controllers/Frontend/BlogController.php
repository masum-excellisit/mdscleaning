<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $query = Blog::published()->orderByDesc('published_at');

        if ($cat = request('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $cat));
        }

        $blogs      = $query->paginate(9)->withQueryString();
        $categories = BlogCategory::has('blogs')->orderBy('name')->get();

        return view('frontend.blog.index', compact('blogs', 'categories'));
    }

    public function show(string $slug): View
    {
        $blog = Blog::with(['author', 'category'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $related = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('blog_category_id', $blog->blog_category_id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('frontend.blog.show', compact('blog', 'related'));
    }
}
