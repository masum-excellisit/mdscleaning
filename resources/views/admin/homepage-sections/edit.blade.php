@extends('layouts.admin')

@section('title', 'Edit Section')
@section('page-title', 'Edit: ' . $section->section_key)

@php
    $imageSections = ['intro', 'about_story'];
    $itemsSections = ['why_choose', 'about_why'];
    $cardsSections = ['about_details', 'service_guarantees'];
    $ctaSections   = ['cta_about', 'cta_services'];
    $key           = $section->section_key;
    $settings      = $section->settings ?? [];
    $currentImage  = $settings['image'] ?? null;
    $currentItems  = implode("\n", $settings['items'] ?? []);
    $currentCards  = $settings['cards'] ?? [];
    while (count($currentCards) < 3) { $currentCards[] = ['icon' => '', 'title' => '', 'text' => '']; }
@endphp

@section('content')
<form method="POST" action="{{ route('admin.homepage-sections.update', $section->id) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="row g-3">

        {{-- Main column --}}
        <div class="col-lg-8">
            <div class="admin-card">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Title</label>
                    <input type="text" name="title" maxlength="255"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $section->title) }}">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Subtitle / Eyebrow</label>
                    <input type="text" name="subtitle" maxlength="500" class="form-control"
                           value="{{ old('subtitle', $section->subtitle) }}"
                           placeholder="Short line shown above the title">
                </div>

                {{-- Body copy for text-heavy sections --}}
                @if(! in_array($key, array_merge($itemsSections, $cardsSections)))
                <div class="mb-0">
                    <label class="form-label fw-semibold">Body Content</label>
                    <textarea name="content" rows="5" class="form-control">{{ old('content', $section->content) }}</textarea>
                    <small class="text-muted">Paragraph copy shown under the heading. HTML is allowed.</small>
                </div>
                @endif

            </div>

            {{-- Items list (why_choose / about_why) --}}
            @if(in_array($key, $itemsSections))
            <div class="admin-card mt-3">
                <label class="form-label fw-semibold">Feature Items <small class="text-muted fw-normal">(one per line)</small></label>
                <textarea name="items" rows="6" class="form-control font-monospace"
                          placeholder="Certified Professional Cleaners&#10;Environmentally Friendly Cleaning&#10;Bonded and Insured&#10;Available Evenings &amp; Weekends">{{ old('items', $currentItems) }}</textarea>
                <small class="text-muted">Each line becomes one numbered card. Up to 4 recommended. HTML entities like <code>&amp;amp;</code> are supported.</small>
            </div>
            @endif

            {{-- Cards repeater (about_details / service_guarantees) --}}
            @if(in_array($key, $cardsSections))
            <div class="admin-card mt-3">
                <p class="fw-semibold mb-3">Cards (3 total)</p>
                @foreach($currentCards as $ci => $card)
                <div class="border rounded p-3 mb-3 bg-light">
                    <div class="small fw-semibold text-muted mb-2">Card {{ $ci + 1 }}</div>
                    <div class="row g-2">
                        <div class="col-md-5">
                            <label class="form-label small">Bootstrap Icon Class</label>
                            <input type="text" name="cards[{{ $ci }}][icon]" class="form-control form-control-sm"
                                   value="{{ old("cards.$ci.icon", $card['icon'] ?? '') }}"
                                   placeholder="bi-shield-check">
                            <small class="text-muted" style="font-size:.7rem;">
                                Browse: <a href="https://icons.getbootstrap.com" target="_blank" rel="noopener">icons.getbootstrap.com</a>
                            </small>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label small">Card Title</label>
                            <input type="text" name="cards[{{ $ci }}][title]" class="form-control form-control-sm"
                                   value="{{ old("cards.$ci.title", $card['title'] ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Card Description</label>
                            <textarea name="cards[{{ $ci }}][text]" rows="2"
                                      class="form-control form-control-sm">{{ old("cards.$ci.text", $card['text'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Image upload (intro / about_story) --}}
            @if(in_array($key, $imageSections))
            <div class="admin-card mt-3">
                <label class="form-label fw-semibold">Section Image</label>
                @if($currentImage)
                    <div class="mb-2">
                        <img src="{{ str_starts_with($currentImage, 'assets/')
                                        ? asset($currentImage)
                                        : \Illuminate\Support\Facades\Storage::url($currentImage) }}"
                             class="img-fluid rounded" style="max-height:160px;">
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" name="remove_image" value="1" id="rmImg" class="form-check-input">
                        <label for="rmImg" class="form-check-label text-danger small">Remove current image</label>
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Recommended: 600×600px portrait. Shown beside the founder text.</small>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label small text-muted text-uppercase" style="font-size:.7rem;">Section Key</label>
                    <input type="text" class="form-control form-control-sm bg-light font-monospace"
                           value="{{ $section->section_key }}" readonly>
                    <small class="text-muted" style="font-size:.7rem;">Read-only — used by the frontend.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" min="0" name="sort_order" class="form-control"
                           value="{{ old('sort_order', $section->sort_order) }}">
                </div>
                <div class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="hs_active"
                           class="form-check-input" @checked(old('is_active', $section->is_active))>
                    <label for="hs_active" class="form-check-label">Visible on website</label>
                </div>
            </div>

            <div class="admin-card mt-3">
                <p class="small text-muted mb-2 fw-semibold">What this section controls</p>
                @switch($key)
                    @case('intro')          <p class="small mb-0">Home page founder intro with portrait photo.</p> @break
                    @case('why_choose')     <p class="small mb-0">Home page "Why Choose Us" numbered cards.</p> @break
                    @case('cta')            <p class="small mb-0">Home page contact/quote form heading and sub-copy.</p> @break
                    @case('about_hero')     <p class="small mb-0">About page top hero banner.</p> @break
                    @case('about_story')    <p class="small mb-0">About page founder story with portrait photo.</p> @break
                    @case('about_why')      <p class="small mb-0">About page "Why Choose Us" numbered cards.</p> @break
                    @case('about_details')  <p class="small mb-0">About page "What Clients Can Expect" icon cards.</p> @break
                    @case('services_hero')  <p class="small mb-0">Services page top hero banner.</p> @break
                    @case('service_guarantees') <p class="small mb-0">Services page "How It Works" steps.</p> @break
                    @case('contact_hero')   <p class="small mb-0">Contact page top hero banner.</p> @break
                    @case('cta_about')      <p class="small mb-0">Mini CTA strip at the bottom of the About page.</p> @break
                    @case('cta_services')   <p class="small mb-0">Mini CTA strip at the bottom of the Services page.</p> @break
                    @default                <p class="small mb-0">General homepage section.</p>
                @endswitch
            </div>
        </div>

    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('admin.homepage-sections.index') }}" class="btn btn-outline-secondary">← Back</a>
        <button class="btn btn-primary"><i class="bi bi-check2"></i> Save Section</button>
    </div>
</form>
@endsection
