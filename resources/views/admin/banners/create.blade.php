@extends('layouts.admin')

@section('title', $banner->exists ? 'Edit Banner' : 'Add Banner')
@section('page-title', $banner->exists ? 'Edit Banner' : 'Add New Banner')

@section('content')
<form method="POST"
      action="{{ $banner->exists ? route('admin.banners.update', $banner->id) : route('admin.banners.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($banner->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" required maxlength="255" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $banner->title) }}">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Subtitle</label>
                    <textarea name="subtitle" rows="2" maxlength="500" class="form-control">{{ old('subtitle', $banner->subtitle) }}</textarea>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Button Text</label>
                        <input type="text" name="button_text" maxlength="100" class="form-control" value="{{ old('button_text', $banner->button_text) }}" placeholder="Shop Now">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Button URL</label>
                        <input type="text" name="button_url" maxlength="255" class="form-control" value="{{ old('button_url', $banner->button_url) }}" placeholder="/contact">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label">Page <span class="text-danger">*</span></label>
                    <select name="page" class="form-select" required>
                        <option value="home" @selected(old('page', $banner->page ?? 'home') === 'home')>Home (hero slider)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
                </div>
                <div class="mb-3 form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="bn_active" class="form-check-input" @checked(old('is_active', $banner->is_active ?? true))>
                    <label for="bn_active" class="form-check-label">Active</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Image @if(! $banner->exists)<span class="text-danger">*</span>@endif</label>
                    @if($banner->image)
                        <img src="{{ $banner->image_url }}" class="img-fluid rounded mb-2">
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*" @if(! $banner->exists) required @endif>
                    <small class="text-muted">Recommended: 1920×700px landscape.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button class="btn btn-primary"><i class="bi bi-check2"></i> Save Banner</button>
    </div>
</form>
@endsection
