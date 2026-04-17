@extends('layouts.admin')

@section('title', 'Inquiry from ' . $inquiry->name)
@section('page-title', 'Inquiry: ' . $inquiry->subject)

@section('content')

<div class="row g-3">
    <div class="col-lg-8">
        <div class="admin-card">
            <p class="text-muted small mb-3">{{ $inquiry->created_at->format('d M Y · g:i A') }} · {{ $inquiry->created_at->diffForHumans() }}</p>
            <h4 class="mb-3">{{ $inquiry->subject }}</h4>
            <div class="p-3 rounded bg-light" style="white-space:pre-wrap; line-height:1.7;">{{ $inquiry->message }}</div>

            <hr>

            <div class="d-flex gap-2">
                <a href="mailto:{{ $inquiry->email }}?subject=Re:%20{{ rawurlencode($inquiry->subject) }}" class="btn btn-primary"><i class="bi bi-reply"></i> Reply by Email</a>
                <form method="POST" action="{{ route('admin.contacts.read', $inquiry->id) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-secondary"><i class="bi bi-{{ $inquiry->is_read ? 'envelope' : 'envelope-open' }}"></i> Mark as {{ $inquiry->is_read ? 'unread' : 'read' }}</button>
                </form>
                <form method="POST" action="{{ route('admin.contacts.destroy', $inquiry->id) }}" class="d-inline ms-auto" onsubmit="return confirm('Delete this inquiry?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card">
            <h6 class="mb-3">Sender</h6>
            <p class="mb-1"><strong>{{ $inquiry->name }}</strong></p>
            <p class="mb-1 small"><i class="bi bi-envelope"></i> <a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></p>
            @if($inquiry->phone)
                <p class="mb-1 small"><i class="bi bi-telephone"></i> {{ $inquiry->phone }}</p>
            @endif
        </div>

        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary w-100">← Back to all inquiries</a>
    </div>
</div>

@endsection
