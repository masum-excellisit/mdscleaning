@extends('layouts.admin')

@section('title', 'Pages')
@section('page-title', 'Static Pages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <form method="GET" class="d-flex gap-2">
        <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Search…" style="width:240px;">
        <button class="btn btn-sm btn-outline-secondary">Search</button>
    </form>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Page</a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th class="text-end" width="180">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td><a href="{{ route('admin.pages.edit', $page->id) }}" class="text-decoration-none fw-semibold">{{ $page->title }}</a></td>
                        <td><code class="small">/pages/{{ $page->slug }}</code></td>
                        <td><span class="badge {{ $page->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $page->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td class="small text-muted">{{ $page->updated_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.pages.destroy', $page->id) }}" class="d-inline" onsubmit="return confirm('Delete this page?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No pages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $pages->links() }}</div>
</div>
@endsection
