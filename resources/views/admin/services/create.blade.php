@extends('layouts.admin')

@section('title', $service->exists ? 'Edit Service' : 'Add Service')
@section('page-title', $service->exists ? 'Edit Service' : 'Add New Service')

@section('content')
<form method="POST"
      action="{{ $service->exists ? route('admin.services.update', $service->id) : route('admin.services.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($service->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="admin-card mb-3">
                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" required maxlength="200" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $service->title) }}">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Short Excerpt</label>
                    <textarea name="excerpt" rows="2" maxlength="500" class="form-control @error('excerpt') is-invalid @enderror">{{ old('excerpt', $service->excerpt) }}</textarea>
                    <small class="text-muted">Shown on service cards. Max 500 chars.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Full Description</label>
                    <textarea name="description" rows="6" class="form-control">{{ old('description', $service->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Features <small class="text-muted">(one per line)</small></label>
                    <textarea name="features" rows="5" class="form-control" placeholder="Deep cleaning of all surfaces&#10;Bathroom & kitchen sanitisation&#10;Eco-friendly products">{{ old('features', $service->features ? implode("\n", $service->features) : '') }}</textarea>
                </div>
            </div>

            <div class="admin-card">
                <h6 class="mb-3 text-muted">SEO</h6>
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" maxlength="200" class="form-control" value="{{ old('meta_title', $service->meta_title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="2" maxlength="500" class="form-control">{{ old('meta_description', $service->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card mb-3">
                <div class="mb-3">
                    <label class="form-label">Bootstrap Icon Class</label>
                    <input type="text" name="icon_class" maxlength="100" class="form-control" value="{{ old('icon_class', $service->icon_class) }}" placeholder="bi-house-check">
                    <small class="text-muted">e.g. <code>bi-house-check</code> — find icons at <a href="https://icons.getbootstrap.com" target="_blank">icons.getbootstrap.com</a></small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order ?? 0) }}">
                </div>
                <div class="mb-3 form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="svc_active" class="form-check-input" @checked(old('is_active', $service->is_active ?? true))>
                    <label for="svc_active" class="form-check-label">Active</label>
                </div>
            </div>

            <div class="admin-card">
                <label class="form-label">Service Image</label>
                @if($service->image)
                    <img src="{{ $service->image_url }}" class="img-fluid rounded mb-2">
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Recommended: 800×600px.</small>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button class="btn btn-primary"><i class="bi bi-check2"></i> Save Service</button>
    </div>
</form>
@endsection
