@extends('layouts.admin')

@section('title', $testimonial->exists ? 'Edit Testimonial' : 'Add Testimonial')
@section('page-title', $testimonial->exists ? 'Edit Testimonial' : 'Add New Testimonial')

@section('content')
<form method="POST"
      action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial->id) : route('admin.testimonials.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($testimonial->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" required maxlength="150" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $testimonial->name) }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Role / Company</label>
                        <input type="text" name="role" maxlength="150" class="form-control" value="{{ old('role', $testimonial->role) }}" placeholder="Homeowner, DFW">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Review <span class="text-danger">*</span></label>
                    <textarea name="content" rows="5" required maxlength="1000" class="form-control @error('content') is-invalid @enderror">{{ old('content', $testimonial->content) }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card mb-3">
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <select name="rating" class="form-select">
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" @selected(old('rating', $testimonial->rating ?? 5) == $i)>
                                {{ $i }} star{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
                </div>
                <div class="mb-3 form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="t_active" class="form-check-input" @checked(old('is_active', $testimonial->is_active ?? true))>
                    <label for="t_active" class="form-check-label">Active</label>
                </div>
            </div>

            <div class="admin-card">
                <label class="form-label">Avatar <small class="text-muted">(optional)</small></label>
                @if($testimonial->avatar)
                    <img src="{{ $testimonial->avatar_url }}" width="60" height="60" style="object-fit:cover;border-radius:50%;" class="d-block mb-2">
                @endif
                <input type="file" name="avatar" class="form-control" accept="image/*">
                <small class="text-muted">Recommended: square, min 150×150px.</small>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button class="btn btn-primary"><i class="bi bi-check2"></i> Save Testimonial</button>
    </div>
</form>
@endsection
