@extends('layouts.admin')

@section('title', $blog->exists ? 'Edit Post' : 'New Post')
@section('page-title', $blog->exists ? 'Edit Post' : 'New Blog Post')

@section('content')
<form method="POST"
      action="{{ $blog->exists ? route('admin.blogs.update', $blog->id) : route('admin.blogs.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($blog->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" required maxlength="255" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blog->title) }}">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug <small class="text-muted">(auto if blank)</small></label>
                    <input type="text" name="slug" maxlength="255" class="form-control" value="{{ old('slug', $blog->slug) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Excerpt <small class="text-muted">(card preview, ≤500 chars)</small></label>
                    <textarea name="excerpt" rows="2" maxlength="500" class="form-control">{{ old('excerpt', $blog->excerpt) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Body <span class="text-danger">*</span></label>
                    <textarea name="body" rows="14" required class="form-control @error('body') is-invalid @enderror">{{ old('body', $blog->body) }}</textarea>
                    @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">HTML is allowed.</small>
                </div>

                <hr>
                <h6>SEO</h6>
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" maxlength="255" class="form-control" value="{{ old('meta_title', $blog->meta_title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="2" maxlength="500" class="form-control">{{ old('meta_description', $blog->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label">Featured Image</label>
                    @if($blog->image)
                        <img src="{{ $blog->image_url }}" class="img-fluid rounded mb-2">
                        <div class="form-check mb-2"><input type="checkbox" name="remove_image" value="1" class="form-check-input" id="rmBlogImg"><label for="rmBlogImg" class="form-check-label small text-danger">Remove image</label></div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Recommended: 1200×630px.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="blog_category_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('blog_category_id', $blog->blog_category_id) == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Publish At</label>
                    <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $blog->published_at?->format('Y-m-d\TH:i')) }}">
                    <small class="text-muted">Set future date to schedule.</small>
                </div>
                <div class="mb-3 form-check">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" id="bp_pub" class="form-check-input" @checked(old('is_published', $blog->is_published))>
                    <label for="bp_pub" class="form-check-label">Published</label>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button class="btn btn-primary"><i class="bi bi-check2"></i> Save Post</button>
    </div>
</form>
@endsection
