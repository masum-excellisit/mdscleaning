@extends('layouts.website')

@section('meta_title', ($page->meta_title ?: $page->title) . ' | ' . setting('site_name', 'MDS Cleaning'))

@section('content')

<section class="main-container">
    <div class="page-hero page-hero-account">
        <div class="page-hero-grid">
            <div class="page-hero-copy">
                <div class="breadcrumb-nav">
                    <span><a href="{{ route('home') }}">Home</a></span>
                    <i class="bi bi-dot"></i>
                    <span>{{ $page->title }}</span>
                </div>
                <span class="page-kicker"><i class="bi bi-layers"></i> Information</span>
                <h1 class="page-title">{{ $page->title }}</h1>
            </div>
            <div class="page-hero-art">
                <img src="{{ asset('assets/extracted/image-02.png') }}" alt="{{ $page->title }}">
            </div>
        </div>
    </div>
</section>

<section class="section-block main-container">
    <article class="content-card" style="max-width:880px; margin:0 auto;">
        <div class="page-body" style="line-height:1.8; font-size:1.02rem; color:#16324a;">
            {!! $page->body !!}
        </div>
    </article>
</section>

@endsection
