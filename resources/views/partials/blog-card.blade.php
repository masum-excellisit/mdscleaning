{{-- Reusable blog card. Expects $blog (App\Models\Blog) and optional $featured (bool). --}}
@php
    $featured = $featured ?? false;
    $cover    = $blog->image_url ?? asset('assets/extracted/image-18.png');
@endphp

<article class="blog-card {{ $featured ? 'featured' : '' }}">
    <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none text-reset d-block h-100">
        <div class="blog-cover" style="background-image:url('{{ $cover }}');"></div>
        <div class="blog-body">
            <div class="blog-meta">
                <span>{{ $blog->category?->name ?? 'Editorial' }}</span>
                <span>{{ $blog->published_at?->format('M Y') ?? $blog->created_at->format('M Y') }}</span>
            </div>
            <h3>{{ $blog->title }}</h3>
            @if($blog->excerpt)
                <p>{{ \Illuminate\Support\Str::limit($blog->excerpt, $featured ? 220 : 140) }}</p>
            @endif
        </div>
    </a>
</article>
