<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function __construct(protected MediaService $media) {}

    public function index(): View
    {
        $testimonials = Testimonial::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        $testimonial = new Testimonial(['is_active' => true, 'sort_order' => 0, 'rating' => 5]);
        return view('admin.testimonials.create', compact('testimonial'));
    }

    public function edit(int $id): View
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.create', compact('testimonial'));
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->save($request, new Testimonial());
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return $this->save($request, Testimonial::findOrFail($id));
    }

    protected function save(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:150'],
            'role'       => ['nullable', 'string', 'max:150'],
            'content'    => ['required', 'string', 'max:1000'],
            'avatar'     => ['nullable', 'image', 'max:2048'],
            'rating'     => ['nullable', 'integer', 'min:1', 'max:5'],
            'is_active'  => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $testimonial->fill([
            'name'       => $data['name'],
            'role'       => $data['role'] ?? null,
            'content'    => $data['content'],
            'rating'     => (int) ($data['rating'] ?? 5),
            'is_active'  => (bool) ($data['is_active'] ?? false),
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar) $this->media->delete($testimonial->avatar);
            $testimonial->avatar = $this->media->store($request->file('avatar'), 'testimonials', [300, 300]);
        }

        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial saved.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $testimonial = Testimonial::findOrFail($id);
        if ($testimonial->avatar) $this->media->delete($testimonial->avatar);
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted.');
    }

    public function toggle(int $id): JsonResponse
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['is_active' => ! $testimonial->is_active]);

        return response()->json(['is_active' => $testimonial->is_active]);
    }
}
