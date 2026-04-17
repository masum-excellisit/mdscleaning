@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Quick Actions --}}
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('admin.services.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Add Service</a>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-newspaper"></i> Add Blog Post</a>
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-chat-dots"></i> View Inquiries
        @if($newInquiries > 0)<span class="badge bg-danger ms-1">{{ $newInquiries }}</span>@endif
    </a>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-gear"></i> Settings</a>
</div>

{{-- Metric Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted small text-uppercase">Services</span>
                <i class="bi bi-shield-check fs-4 text-primary"></i>
            </div>
            <h3 class="mb-1">{{ $totalServices }}</h3>
            <span class="small text-success">{{ $activeServices }} active</span>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted small text-uppercase">Testimonials</span>
                <i class="bi bi-chat-quote fs-4 text-primary"></i>
            </div>
            <h3 class="mb-1">{{ $totalTestimonials }}</h3>
            <a href="{{ route('admin.testimonials.index') }}" class="small text-decoration-none">View all <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted small text-uppercase">Blog Posts</span>
                <i class="bi bi-newspaper fs-4 text-primary"></i>
            </div>
            <h3 class="mb-1">{{ $totalBlogs }}</h3>
            <span class="small text-muted">{{ $publishedBlogs }} published</span>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted small text-uppercase">Inquiries</span>
                <i class="bi bi-envelope fs-4 {{ $newInquiries > 0 ? 'text-danger' : 'text-primary' }}"></i>
            </div>
            <h3 class="mb-1 {{ $newInquiries > 0 ? 'text-danger' : '' }}">{{ $newInquiries }}</h3>
            <span class="small text-muted">{{ $totalInquiries }} total received</span>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Recent Inquiries --}}
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0"><i class="bi bi-chat-dots text-primary"></i> Recent Contact Inquiries</h6>
                <a href="{{ route('admin.contacts.index') }}" class="small text-decoration-none">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Received</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentInquiries as $msg)
                            <tr>
                                <td class="fw-semibold small">{{ $msg->name }}</td>
                                <td class="small text-muted">{{ $msg->email }}</td>
                                <td class="small text-muted">{{ $msg->phone ?? '—' }}</td>
                                <td class="small text-muted">{{ $msg->created_at->diffForHumans() }}</td>
                                <td>
                                    @if($msg->is_read)
                                        <span class="badge bg-secondary">Read</span>
                                    @else
                                        <span class="badge bg-danger">New</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No inquiries yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Unread Inquiries --}}
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0"><i class="bi bi-bell text-warning"></i> Unread Messages</h6>
                <a href="{{ route('admin.contacts.index') }}" class="small text-decoration-none">View all</a>
            </div>
            @forelse($unreadInquiries as $msg)
                <div class="py-2 border-bottom">
                    <div class="d-flex justify-content-between">
                        <div class="small fw-semibold">{{ $msg->name }}</div>
                        <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="text-muted small text-truncate">{{ $msg->message }}</div>
                    <form method="POST" action="{{ route('admin.contacts.read', $msg->id) }}" class="mt-1">
                        @csrf
                        <button type="submit" class="btn btn-xs btn-outline-secondary" style="font-size:.7rem; padding:1px 6px;">Mark Read</button>
                    </form>
                </div>
            @empty
                <p class="text-muted small mb-0 text-center py-3">No unread messages.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
