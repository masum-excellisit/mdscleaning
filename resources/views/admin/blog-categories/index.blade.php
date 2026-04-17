@extends('layouts.admin')

@section('title', 'Blog Categories')
@section('page-title', 'Blog Categories')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="admin-card">
            <h6 class="mb-3">Add Category</h6>
            <form method="POST" action="{{ route('admin.blog-categories.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label small">Name</label>
                    <input type="text" name="name" required maxlength="255" class="form-control form-control-sm">
                </div>
                <button class="btn btn-sm btn-primary w-100"><i class="bi bi-plus-lg"></i> Add</button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="admin-card">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-center">Posts</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            <td>{{ $cat->name }}</td>
                            <td><code class="small">{{ $cat->slug }}</code></td>
                            <td class="text-center">{{ $cat->blogs_count }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.blog-categories.destroy', $cat->id) }}" onsubmit="return confirm('Remove this category?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No categories yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
