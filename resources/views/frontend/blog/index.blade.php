@extends('layouts.website')

@section('meta_title', 'Blog | ' . setting('site_name', 'MDS Cleaning'))

@section('content')

<section class="main-container">
    <div class="page-hero page-hero-blog">
        <div class="page-hero-grid">
            <div class="page-hero-copy">
                <div class="breadcrumb-nav">
                    <span><a href="{{ route('home') }}">Home</a></span>
                    <i class="bi bi-dot"></i>
                    <span>Blog</span>
                </div>
                <span class="page-kicker"><i class="bi bi-journal-richtext"></i> Editorial Content</span>
                <h1 class="page-title">Stories, styling notes, and product-led content that supports the store.</h1>
                <p class="page-subtitle">The blog extends the cstees experience with editorial surfaces that still feel connected to the brand through consistent spacing, color, and card logic.</p>
            </div>
            <div class="page-hero-art">
                <img src="{{ asset('assets/extracted/image-18.png') }}" alt="Editorial collage">
            </div>
        </div>
    </div>
</section>

@if($categories->count())
<section class="main-container">
    <div class="chip-list" style="padding:0 0 1rem;">
        <a class="filter-chip {{ ! request('category') ? 'active' : '' }}" href="{{ route('blog.index') }}">All</a>
        @foreach($categories as $cat)
            <a class="filter-chip {{ request('category') === $cat->slug ? 'active' : '' }}"
               href="{{ route('blog.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a>
        @endforeach
    </div>
</section>
@endif

<section class="section-block main-container">
    @if($blogs->isEmpty())
        <div class="content-card text-center py-5">
            <i class="bi bi-journal-x" style="font-size:3rem; color:#79afe3;"></i>
            <h3 class="mt-3">No posts yet</h3>
            <p class="section-subtitle">Check back soon — fresh stories drop weekly.</p>
        </div>
    @else
        <div class="blog-grid">
            @foreach($blogs as $i => $blog)
                @include('partials.blog-card', [
                    'blog'     => $blog,
                    'featured' => $i === 0 && $blogs->onFirstPage(),
                ])
            @endforeach
        </div>

        @if($blogs->hasPages())
            <div class="pagination-shell mt-4">
                {{ $blogs->onEachSide(1)->links('pagination::simple-bootstrap-5') }}
            </div>
        @endif
    @endif
</section>

@endsection
