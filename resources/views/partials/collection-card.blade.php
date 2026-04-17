{{-- Reusable collection card. Expects $collection (App\Models\Collection) and optional $index (string label). --}}
@php
    $imgUrl = null;
    if ($collection->image) {
        $imgUrl = str_starts_with($collection->image, 'assets/') || str_starts_with($collection->image, 'http')
            ? asset(ltrim($collection->image, '/'))
            : \Illuminate\Support\Facades\Storage::url($collection->image);
    }
@endphp

<article class="page-link-card">
    @if($imgUrl)
        <div class="page-link-media">
            <img src="{{ $imgUrl }}" alt="{{ $collection->name }}" loading="lazy">
        </div>
    @endif
    <div class="page-link-body">
        @isset($index)<span class="section-kicker">{{ $index }}</span>@endisset
        <h3>{{ $collection->name }}</h3>
        @if($collection->description)
            <p>{{ \Illuminate\Support\Str::limit($collection->description, 110) }}</p>
        @endif
        @if(isset($collection->products_count))
            <p class="page-link-count"><i class="bi bi-bag"></i> {{ $collection->products_count }} {{ \Illuminate\Support\Str::plural('product', $collection->products_count) }}</p>
        @endif
        <div class="page-link-actions">
            <a class="action-primary" href="{{ route('collections.show', $collection->slug) }}">Open Collection</a>
        </div>
    </div>
</article>
