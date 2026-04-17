@extends('layouts.admin')

@section('title', 'Settings')
@section('page-title', 'Site Settings')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf

    <div class="admin-card p-0">
        <ul class="nav nav-tabs px-3 pt-3" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#t-general"  type="button">General</button></li>
            <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#t-contact"  type="button">Contact & Hours</button></li>
            <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#t-social"   type="button">Social</button></li>
            <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#t-seo"      type="button">SEO</button></li>
            <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#t-mail"     type="button">Mail</button></li>
        </ul>

        <div class="tab-content p-4">

            {{-- General --}}
            <div class="tab-pane fade show active" id="t-general">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Site Name</label>
                        <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'MDS Cleaning' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Site Tagline</label>
                        <input type="text" name="site_tagline" class="form-control" value="{{ $settings['site_tagline'] ?? 'One Call Cleans It All' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Announcement Bar Text</label>
                        <input type="text" name="announcement_text" class="form-control" value="{{ $settings['announcement_text'] ?? 'Accepting Commercial Cleaning Contracts from small to medium sized properties' }}">
                        <small class="text-muted">Displayed in the top strip across all pages.</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Footer Tagline</label>
                        <textarea name="footer_tagline" rows="2" class="form-control">{{ $settings['footer_tagline'] ?? '' }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Logo</label>
                        @if($logo = ($settings['logo'] ?? null))
                            <div class="mb-2"><img src="{{ str_starts_with($logo,'assets/')?asset($logo):\Illuminate\Support\Facades\Storage::url($logo) }}" style="max-height:48px;"></div>
                            <div class="form-check small mb-2">
                                <input type="checkbox" name="remove_logo" value="1" id="rmLogo" class="form-check-input">
                                <label for="rmLogo" class="form-check-label text-danger">Remove</label>
                            </div>
                        @endif
                        <input type="file" name="logo" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Favicon</label>
                        @if($fav = ($settings['favicon'] ?? null))
                            <div class="mb-2"><img src="{{ str_starts_with($fav,'assets/')?asset($fav):\Illuminate\Support\Facades\Storage::url($fav) }}" style="max-height:32px;"></div>
                        @endif
                        <input type="file" name="favicon" class="form-control form-control-sm" accept="image/*">
                    </div>
                </div>
            </div>

            {{-- Contact & Hours --}}
            <div class="tab-pane fade" id="t-contact">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $settings['phone'] ?? '' }}" placeholder="8179890656">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">WhatsApp Number</label>
                        <input type="text" name="whatsapp" class="form-control" value="{{ $settings['whatsapp'] ?? '' }}" placeholder="18179890656 (no + or spaces)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="2" class="form-control">{{ $settings['address'] ?? '' }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Business Hours</label>
                        <textarea name="business_hours" rows="3" class="form-control" placeholder="Mon - Fri: 8am - 8pm&#10;Saturday: 9am - 7pm&#10;Sunday: 9am - 8pm">{{ $settings['business_hours'] ?? '' }}</textarea>
                        <small class="text-muted">Each line is rendered separately on the contact page.</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Map Embed Code</label>
                        <textarea name="map_embed_url" rows="3" class="form-control" placeholder="Paste full Google Maps embed &lt;iframe&gt; code here">{{ $settings['map_embed_url'] ?? '' }}</textarea>
                        <small class="text-muted">Paste the full &lt;iframe&gt; embed code from Google Maps. Leave blank to show the static map image.</small>
                    </div>
                </div>
            </div>

            {{-- Social --}}
            <div class="tab-pane fade" id="t-social">
                <div class="row g-3">
                    @foreach(['facebook_url'=>'Facebook','instagram_url'=>'Instagram','twitter_url'=>'Twitter / X','youtube_url'=>'YouTube'] as $k => $label)
                        <div class="col-md-6">
                            <label class="form-label">{{ $label }}</label>
                            <input type="url" name="{{ $k }}" class="form-control" value="{{ $settings[$k] ?? '' }}" placeholder="https://...">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- SEO --}}
            <div class="tab-pane fade" id="t-seo">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Default Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ $settings['meta_title'] ?? 'MDS Cleaning | Professional Cleaning Services' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Default Meta Description</label>
                        <textarea name="meta_description" rows="2" class="form-control">{{ $settings['meta_description'] ?? '' }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Google Analytics ID</label>
                        <input type="text" name="google_analytics_id" class="form-control" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXXXX">
                    </div>
                </div>
            </div>

            {{-- Mail --}}
            <div class="tab-pane fade" id="t-mail">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">From Address</label>
                        <input type="email" name="mail_from_address" class="form-control" value="{{ $settings['mail_from_address'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">From Name</label>
                        <input type="text" name="mail_from_name" class="form-control" value="{{ $settings['mail_from_name'] ?? 'MDS Cleaning' }}">
                    </div>
                    <div class="col-12">
                        <div class="alert alert-info small mb-0">SMTP host/port/credentials are configured in <code>.env</code>. These fields control the "from" headers used in outgoing emails.</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-primary"><i class="bi bi-check2"></i> Save Settings</button>
    </div>
</form>
@endsection
