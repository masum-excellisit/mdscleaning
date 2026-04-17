@extends('layouts.admin')

@section('title', 'Contact Inquiries')
@section('page-title', 'Contact Inquiries')

@section('content')

<div class="admin-card mb-3">
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm {{ ! request('status') ? 'btn-dark' : 'btn-outline-dark' }}">All <span class="badge bg-light text-dark ms-1">{{ $counts['all'] }}</span></a>
        <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}" class="btn btn-sm {{ request('status') === 'unread' ? 'btn-dark' : 'btn-outline-dark' }}">Unread <span class="badge bg-warning text-dark ms-1">{{ $counts['unread'] }}</span></a>
        <a href="{{ route('admin.contacts.index', ['status' => 'read']) }}" class="btn btn-sm {{ request('status') === 'read' ? 'btn-dark' : 'btn-outline-dark' }}">Read <span class="badge bg-secondary ms-1">{{ $counts['read'] }}</span></a>
    </div>
</div>

<div class="admin-card">
    <form method="GET" class="d-flex gap-2 mb-3">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Search name, email, subject…" style="width:300px;">
        <button class="btn btn-sm btn-outline-secondary">Search</button>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th></th>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Received</th>
                    <th class="text-end" width="160">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inquiries as $inq)
                    <tr class="{{ $inq->is_read ? '' : 'fw-semibold' }}">
                        <td>
                            @if(! $inq->is_read)
                                <span class="badge bg-warning text-dark">NEW</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.contacts.show', $inq->id) }}" class="text-decoration-none">{{ $inq->name }}</a>
                            <div class="text-muted small">{{ $inq->email }}</div>
                        </td>
                        <td><a href="{{ route('admin.contacts.show', $inq->id) }}" class="text-decoration-none">{{ $inq->subject }}</a></td>
                        <td class="small text-muted">{{ $inq->created_at->diffForHumans() }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.contacts.show', $inq->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <form method="POST" action="{{ route('admin.contacts.read', $inq->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary" title="Toggle read"><i class="bi bi-{{ $inq->is_read ? 'envelope-open' : 'envelope' }}"></i></button>
                            </form>
                            <form method="POST" action="{{ route('admin.contacts.destroy', $inq->id) }}" class="d-inline" onsubmit="return confirm('Delete this inquiry?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No inquiries.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $inquiries->links() }}</div>
</div>
@endsection
