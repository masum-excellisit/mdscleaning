@extends('layouts.website')

@section('meta_title', ($blog->meta_title ?: $blog->title) . ' | ' . setting('site_name', 'MDS Cleaning'))

@section('content')

<section class="main-container">
    <div class="page-hero page-hero-blog">
        <div class="page-hero-copy" style="max-width:760px;">
            <div class="breadcrumb-nav">
                <span><a href="{{ route('home') }}">Home</a></span>
                <i class="bi bi-dot"></i>
                <span><a href="{{ route('blog.index') }}">Blog</a></span>
                <i class="bi bi-dot"></i>
                <span>{{ \Illuminate\Support\Str::limit($blog->title, 60) }}</span>
            </div>
            <span class="page-kicker"><i class="bi bi-journal-richtext"></i> {{ $blog->category?->name ?? 'Editorial' }}</span>
            <h1 class="page-title">{{ $blog->title }}</h1>
            <p class="page-subtitle">
                @if($blog->author) By {{ $blog->author->name }} · @endif
                {{ $blog->published_at?->format('d M Y') ?? $blog->created_at->format('d M Y') }}
            </p>
        </div>
    </div>
</section>

<section class="section-block main-container">
    <article class="content-card" style="max-width:860px; margin:0 auto;">
        @if($blog->image)
            <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="img-fluid rounded mb-4" style="width:100%; aspect-ratio:16/8; object-fit:cover;">
        @endif

        @if($blog->excerpt)
            <p class="lead section-subtitle" style="font-size:1.15rem;">{{ $blog->excerpt }}</p>
        @endif

        <div class="blog-body-content" style="line-height:1.8; font-size:1.02rem; color:#16324a;">
            {!! $blog->body !!}
        </div>

        <hr class="my-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <p class="mb-0 small text-muted">
                @if($blog->author) Written by <strong>{{ $blog->author->name }}</strong> · @endif
                Filed in {{ $blog->category?->name ?? 'Editorial' }}
            </p>
            <a href="{{ route('blog.index') }}" class="action-secondary">← All posts</a>
        </div>
    </article>
</section>

@if($related->count())
<section class="section-block main-container">
    <div class="section-head">
        <div>
            <span class="section-kicker">Keep Reading</span>
            <h2 class="section-title">Related Stories</h2>
        </div>
    </div>
    <div class="blog-grid">
        @foreach($related as $blog)
            @include('partials.blog-card', ['blog' => $blog])
        @endforeach
    </div>
</section>
@endif

@endsection
