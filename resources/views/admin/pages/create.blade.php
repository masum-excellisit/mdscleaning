@extends('layouts.admin')

@section('title', $page->exists ? 'Edit Page' : 'New Page')
@section('page-title', $page->exists ? 'Edit Page: ' . $page->title : 'New Page')

@section('content')
<form method="POST" action="{{ $page->exists ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}">
    @csrf
    @if($page->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" required maxlength="255" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug <small class="text-muted">(auto if blank, e.g. <code>privacy-policy</code>)</small></label>
                    <input type="text" name="slug" maxlength="255" class="form-control" value="{{ old('slug', $page->slug) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Body <span class="text-danger">*</span></label>
                    <textarea name="body" rows="16" required class="form-control @error('body') is-invalid @enderror">{{ old('body', $page->body) }}</textarea>
                    @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">HTML is allowed.</small>
                </div>
                <hr>
                <h6>SEO</h6>
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" maxlength="255" class="form-control" value="{{ old('meta_title', $page->meta_title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="2" maxlength="500" class="form-control">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card">
                <div class="mb-3 form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="pg_active" class="form-check-input" @checked(old('is_active', $page->is_active ?? true))>
                    <label for="pg_active" class="form-check-label">Active</label>
                </div>
                @if($page->exists)
                    <p class="small text-muted">View live: <a href="{{ route('pages.show', $page->slug) }}" target="_blank">/pages/{{ $page->slug }}</a></p>
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button class="btn btn-primary"><i class="bi bi-check2"></i> Save Page</button>
    </div>
</form>
@endsection
