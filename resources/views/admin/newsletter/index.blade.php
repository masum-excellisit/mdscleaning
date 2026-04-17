@extends('layouts.admin')

@section('title', 'Newsletter Subscribers')
@section('page-title', 'Newsletter Subscribers')

@section('content')

{{-- Stats --}}
<div class="row g-3 mb-3">
    <div class="col-md-3"><div class="admin-card"><span class="text-muted small">Total</span><h3 class="mb-0">{{ $stats['total'] }}</h3></div></div>
    <div class="col-md-3"><div class="admin-card"><span class="text-muted small">Active</span><h3 class="mb-0 text-success">{{ $stats['active'] }}</h3></div></div>
    <div class="col-md-3"><div class="admin-card"><span class="text-muted small">Inactive</span><h3 class="mb-0 text-secondary">{{ $stats['inactive'] }}</h3></div></div>
    <div class="col-md-3"><div class="admin-card"><span class="text-muted small">New (30 days)</span><h3 class="mb-0 text-primary">{{ $stats['last_30'] }}</h3></div></div>
</div>

<form method="POST" action="{{ route('admin.newsletter.bulk') }}" id="nlBulkForm" onsubmit="return confirm('Delete selected subscribers?');">
    @csrf
    <div class="admin-card">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <form method="GET" class="d-flex gap-2">
                <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Search email…" style="width:240px;">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="active" @selected(request('status')==='active')>Active</option>
                    <option value="inactive" @selected(request('status')==='inactive')>Inactive</option>
                </select>
                <button class="btn btn-sm btn-outline-secondary">Filter</button>
            </form>

            <div class="d-flex gap-2">
                <button form="nlBulkForm" type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete Selected</button>
                <a href="{{ route('admin.newsletter.export') }}" class="btn btn-sm btn-outline-dark"><i class="bi bi-download"></i> Export CSV</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40"><input type="checkbox" id="nlCheckAll" class="form-check-input"></th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Subscribed</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $sub)
                        <tr>
                            <td><input type="checkbox" name="ids[]" value="{{ $sub->id }}" class="form-check-input nl-row-check"></td>
                            <td>{{ $sub->email }}</td>
                            <td><span class="badge {{ $sub->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $sub->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td class="small text-muted">{{ optional($sub->subscribed_at)->format('d M Y g:i A') }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.newsletter.destroy', $sub->id) }}" class="d-inline" onsubmit="return confirm('Remove this subscriber?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No subscribers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $subscribers->links() }}</div>
    </div>
</form>

@endsection

@push('scripts')
<script>
document.getElementById('nlCheckAll')?.addEventListener('change', function () {
    document.querySelectorAll('.nl-row-check').forEach(cb => cb.checked = this.checked);
});
</script>
@endpush
