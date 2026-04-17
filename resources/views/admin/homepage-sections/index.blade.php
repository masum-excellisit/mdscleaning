@extends('layouts.admin')

@section('title', 'Homepage Sections')
@section('page-title', 'Homepage Sections')

@section('content')
<div class="alert alert-info small">
    <i class="bi bi-info-circle me-1"></i>
    Toggle a section off to hide it from the homepage without deleting it.
    Click <strong>Edit</strong> to update its title, subtitle, and content.
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="60">Order</th>
                    <th>Section</th>
                    <th>Title shown on homepage</th>
                    <th>Status</th>
                    <th class="text-end" width="180">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sections as $section)
                    <tr>
                        <td>{{ $section->sort_order }}</td>
                        <td><code class="small">{{ $section->section_key }}</code></td>
                        <td>
                            <strong>{{ $section->title ?? '—' }}</strong>
                            @if($section->subtitle)<div class="text-muted small">{{ \Illuminate\Support\Str::limit($section->subtitle, 80) }}</div>@endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.homepage-sections.toggle', $section->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm border-0 bg-transparent p-0">
                                    <span class="badge {{ $section->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $section->is_active ? 'Active' : 'Hidden' }}
                                    </span>
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.homepage-sections.edit', $section->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
