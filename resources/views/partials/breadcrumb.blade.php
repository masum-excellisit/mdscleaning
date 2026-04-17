{{-- Reusable breadcrumb. Pass $crumbs as an array of [label => url|null].
     The last entry should have null URL (current page). --}}
@php $crumbs = $crumbs ?? []; @endphp

@if(! empty($crumbs))
    <div class="breadcrumb-nav">
        @foreach($crumbs as $label => $url)
            @if(! $loop->first)<i class="bi bi-dot"></i>@endif
            @if($url)
                <span><a href="{{ $url }}">{{ $label }}</a></span>
            @else
                <span>{{ $label }}</span>
            @endif
        @endforeach
    </div>
@endif
