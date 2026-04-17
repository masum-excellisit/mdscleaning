@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('page-title', 'Blog Posts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <form method="GET" class="d-flex gap-2 align-items-center">
        <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Search title…" style="width:240px;">
        <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">All categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">All statuses</option>
            <option value="published" @selected(request('status')==='published')>Published</option>
            <option value="draft" @selected(request('status')==='draft')>Draft</option>
        </select>
        <button class="btn btn-sm btn-outline-secondary">Filter</button>
    </form>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-outline-dark"><i class="bi bi-bookmark"></i> Categories</a>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Post</a>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="80">Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Published</th>
                    <th>Status</th>
                    <th class="text-end" width="140">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                    <tr>
                        <td>
                            @if($blog->image)
                                <img src="{{ $blog->image_url }}" width="64" height="40" style="object-fit:cover; border-radius:6px;">
                            @else
                                <div style="width:64px; height:40px; background:#f1f5f9; border-radius:6px;" class="d-flex align-items-center justify-content-center"><i class="bi bi-image text-muted"></i></div>
                            @endif
                        </td>
                        <td><a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-decoration-none fw-semibold">{{ $blog->title }}</a></td>
                        <td class="small">{{ $blog->category?->name ?? '—' }}</td>
                        <td class="small">{{ $blog->author?->name ?? '—' }}</td>
                        <td class="small text-muted">{{ $blog->published_at?->format('d M Y') ?? '—' }}</td>
                        <td><span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-secondary' }}">{{ $blog->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="text-end">
                            @if($blog->is_published)
                                <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            @endif
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.blogs.destroy', $blog->id) }}" class="d-inline" onsubmit="return confirm('Delete this post?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No posts yet. <a href="{{ route('admin.blogs.create') }}">Write your first one</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $blogs->links() }}</div>
</div>
@endsection
