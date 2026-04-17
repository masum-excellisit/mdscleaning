@extends('layouts.admin')

@section('title', 'Testimonials')
@section('page-title', 'Testimonials')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Testimonial</a>
</div>

<div class="admin-card">
    @if($testimonials->isEmpty())
        <p class="text-muted text-center py-4 mb-0">No testimonials yet. <a href="{{ route('admin.testimonials.create') }}">Add the first one</a>.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60">Avatar</th>
                        <th>Name / Role</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Sort</th>
                        <th>Status</th>
                        <th class="text-end" width="130">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testimonials as $t)
                        <tr>
                            <td>
                                <img src="{{ $t->avatar_url }}" width="44" height="44" style="object-fit:cover; border-radius:50%;">
                            </td>
                            <td>
                                <strong>{{ $t->name }}</strong>
                                @if($t->role)<div class="text-muted small">{{ $t->role }}</div>@endif
                            </td>
                            <td class="text-muted small">{{ \Illuminate\Support\Str::limit($t->content, 80) }}</td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $t->rating ? '-fill text-warning' : ' text-muted' }}" style="font-size:.8rem"></i>
                                @endfor
                            </td>
                            <td>{{ $t->sort_order }}</td>
                            <td>
                                <span class="badge {{ $t->is_active ? 'bg-success' : 'bg-secondary' }} status-badge"
                                      style="cursor:pointer"
                                      data-id="{{ $t->id }}"
                                      data-url="{{ route('admin.testimonials.toggle', $t->id) }}">
                                    {{ $t->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.testimonials.destroy', $t->id) }}" class="d-inline" onsubmit="return confirm('Delete this testimonial?');">
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
