@extends('layouts.admin')

@section('title', 'FAQs')
@section('page-title', 'FAQs')

@section('content')

<div class="row g-3">
    <div class="col-lg-5">
        <div class="admin-card">
            <h6 class="mb-3">{{ $editFaq ? 'Edit FAQ' : 'Add FAQ' }}</h6>
            <form method="POST" action="{{ $editFaq ? route('admin.faqs.update', $editFaq->id) : route('admin.faqs.store') }}">
                @csrf
                @if($editFaq) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label small">Question</label>
                    <input type="text" name="question" required maxlength="500" class="form-control form-control-sm" value="{{ old('question', $editFaq->question ?? '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label small">Answer</label>
                    <textarea name="answer" rows="5" required class="form-control form-control-sm">{{ old('answer', $editFaq->answer ?? '') }}</textarea>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small">Sort Order</label>
                        <input type="number" min="0" name="sort_order" class="form-control form-control-sm" value="{{ old('sort_order', $editFaq->sort_order ?? '') }}">
                    </div>
                    <div class="col-6 form-check ms-3 mt-4">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" id="fq_active" class="form-check-input" @checked(old('is_active', $editFaq->is_active ?? true))>
                        <label for="fq_active" class="form-check-label small">Active</label>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-sm btn-primary"><i class="bi bi-check2"></i> {{ $editFaq ? 'Update' : 'Add FAQ' }}</button>
                    @if($editFaq)
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-outline-secondary">Cancel</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="admin-card">
            @forelse($faqs as $faq)
                <div class="border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="flex-grow-1">
                            <strong>{{ $faq->question }}</strong>
                            @if(! $faq->is_active)<span class="badge bg-secondary ms-1">Hidden</span>@endif
                            <div class="small text-muted mt-1">{{ \Illuminate\Support\Str::limit($faq->answer, 180) }}</div>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.faqs.index', ['edit' => $faq->id]) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $faq->id) }}" onsubmit="return confirm('Delete this FAQ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center py-4 mb-0">No FAQs yet.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
