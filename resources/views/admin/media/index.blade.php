@extends('layouts.admin')

@section('title', 'Media Library')
@section('page-title', 'Media Library')

@section('content')

<div class="admin-card">
    <h6 class="mb-3"><i class="bi bi-cloud-upload"></i> Upload Files</h6>
    <form method="POST" action="{{ route('admin.media.upload') }}" enctype="multipart/form-data" class="d-flex gap-2 align-items-end">
        @csrf
        <input type="file" name="files[]" multiple required accept="image/*"
               class="form-control form-control-sm">
        <button class="btn btn-sm btn-primary"><i class="bi bi-upload"></i> Upload</button>
    </form>
    <small class="text-muted">JPG / PNG / WebP / GIF / SVG — up to 4 MB each.</small>
</div>

<div class="admin-card">
    <form method="GET" class="d-flex gap-2 mb-3">
        <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Search filename…" style="width:240px;">
        <select name="type" class="form-select form-select-sm">
            <option value="">All types</option>
            <option value="image" @selected(request('type')==='image')>Image</option>
            <option value="document" @selected(request('type')==='document')>Document</option>
        </select>
        <button class="btn btn-sm btn-outline-secondary">Filter</button>
    </form>

    @if($media->isEmpty())
        <p class="text-muted text-center py-5 mb-0"><i class="bi bi-images" style="font-size:2.5rem; display:block;"></i>No files yet. Upload some above.</p>
    @else
        <div class="row g-2">
            @foreach($media as $file)
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="border rounded p-2 h-100">
                        <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="d-block mb-2">
                            <img src="{{ Storage::url($file->file_path) }}" class="img-fluid rounded" style="aspect-ratio:1/1; object-fit:cover; background:#f1f5f9;">
                        </a>
                        <div class="small text-truncate" title="{{ $file->file_name }}">{{ $file->file_name }}</div>
                        <div class="small text-muted">{{ $file->human_size }}</div>
                        <div class="d-flex gap-1 mt-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary flex-grow-1 js-copy-url" data-url="{{ Storage::url($file->file_path) }}"><i class="bi bi-clipboard"></i> Copy URL</button>
                            <form method="POST" action="{{ route('admin.media.destroy', $file->id) }}" onsubmit="return confirm('Delete this file?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">{{ $media->links() }}</div>
    @endif
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.js-copy-url').forEach(btn => {
    btn.addEventListener('click', function () {
        navigator.clipboard.writeText(this.dataset.url);
        const orig = this.innerHTML;
        this.innerHTML = '<i class="bi bi-check2"></i> Copied!';
        setTimeout(() => this.innerHTML = orig, 1500);
    });
});
</script>
@endpush
