<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pick Media</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { padding: 1rem; background: #f8fafc; }
        .pickable { cursor: pointer; transition: transform .12s; }
        .pickable:hover { transform: translateY(-2px); }
    </style>
</head>
<body>
    <h6 class="mb-3">Choose an image</h6>
    <div class="row g-2">
        @forelse($media as $file)
            <div class="col-md-3 col-sm-4 col-6">
                <div class="border rounded p-2 pickable text-center"
                     onclick="window.parent.postMessage({type:'media-picked', url:'{{ Storage::url($file->file_path) }}', id:{{ $file->id }} }, '*')">
                    <img src="{{ Storage::url($file->file_path) }}" class="img-fluid rounded" style="aspect-ratio:1/1; object-fit:cover;">
                    <div class="small text-truncate mt-1">{{ $file->file_name }}</div>
                </div>
            </div>
        @empty
            <p class="text-muted text-center py-4">No media uploaded yet.</p>
        @endforelse
    </div>
    <div class="mt-3">{{ $media->links() }}</div>
</body>
</html>
