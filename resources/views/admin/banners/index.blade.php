@extends('layouts.admin')

@section('title', 'Banners')
@section('page-title', 'Banners')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <form method="GET" class="d-flex gap-2">
        <select name="page" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">All pages</option>
            <option value="home" @selected(request('page')==='home')>Home</option>
        </select>
    </form>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Banner</a>
</div>

<div class="admin-card">
    @if($banners->isEmpty())
        <p class="text-muted text-center py-4 mb-0">No banners yet. <a href="{{ route('admin.banners.create') }}">Add the first one</a>.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="100">Image</th>
                        <th>Title</th>
                        <th>Page</th>
                        <th>Sort</th>
                        <th>Status</th>
                        <th class="text-end" width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $b)
                        <tr>
                            <td>
                                @if($b->image)
                                    <img src="{{ $b->image_url }}" width="100" height="44" style="object-fit:cover; border-radius:6px;">
                                @endif
                            </td>
                            <td>
                                <strong>{{ $b->title }}</strong>
                                @if($b->subtitle)<div class="text-muted small">{{ \Illuminate\Support\Str::limit($b->subtitle, 60) }}</div>@endif
                            </td>
                            <td><span class="badge bg-light text-dark">{{ ucfirst($b->page) }}</span></td>
                            <td>{{ $b->sort_order }}</td>
                            <td><span class="badge {{ $b->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $b->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.banners.edit', $b->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.banners.destroy', $b->id) }}" class="d-inline" onsubmit="return confirm('Delete this banner?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
