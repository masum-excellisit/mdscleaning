@extends('layouts.admin')

@section('title', 'Services')
@section('page-title', 'Services')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Service</a>
</div>

<div class="admin-card">
    @if($services->isEmpty())
        <p class="text-muted text-center py-4 mb-0">No services yet. <a href="{{ route('admin.services.create') }}">Add the first one</a>.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="90">Image</th>
                        <th>Title</th>
                        <th>Icon</th>
                        <th>Sort</th>
                        <th>Status</th>
                        <th class="text-end" width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $s)
                        <tr>
                            <td>
                                @if($s->image)
                                    <img src="{{ $s->image_url }}" width="80" height="50" style="object-fit:cover; border-radius:6px;">
                                @endif
                            </td>
                            <td>
                                <strong>{{ $s->title }}</strong>
                                @if($s->excerpt)<div class="text-muted small">{{ \Illuminate\Support\Str::limit($s->excerpt, 70) }}</div>@endif
                            </td>
                            <td>
                                @if($s->icon_class)
                                    <i class="bi {{ $s->icon_class }} fs-5"></i>
                                    <span class="text-muted small d-block">{{ $s->icon_class }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $s->sort_order }}</td>
                            <td>
                                <span class="badge {{ $s->is_active ? 'bg-success' : 'bg-secondary' }} status-badge"
                                      style="cursor:pointer"
                                      data-id="{{ $s->id }}"
                                      data-url="{{ route('admin.services.toggle', $s->id) }}">
                                    {{ $s->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.services.edit', $s->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.services.destroy', $s->id) }}" class="d-inline" onsubmit="return confirm('Delete this service?');">
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

@push('scripts')
<script>
document.querySelectorAll('.status-badge').forEach(badge => {
    badge.addEventListener('click', function () {
        fetch(this.dataset.url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(d => {
            this.textContent = d.is_active ? 'Active' : 'Inactive';
            this.className = 'badge status-badge ' + (d.is_active ? 'bg-success' : 'bg-secondary');
        });
    });
});
</script>
@endpush
