<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function __construct(protected MediaService $media) {}

    public function index(Request $request): View
    {
        $q = Banner::query();
        if ($page = $request->string('page')->toString()) {
            $q->where('page', $page);
        }
        $banners = $q->orderBy('page')->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.banners.index', compact('banners'));
    }

    public function create(): View
    {
        $banner = new Banner(['page' => 'home', 'is_active' => true, 'sort_order' => 0]);
        return view('admin.banners.create', compact('banner'));
    }

    public function edit(int $id): View
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.create', compact('banner'));
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->save($request, new Banner());
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return $this->save($request, Banner::findOrFail($id));
    }

    protected function save(Request $request, Banner $banner): RedirectResponse
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:500'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url'  => ['nullable', 'string', 'max:255'],
            'image'       => [$banner->exists ? 'nullable' : 'required', 'image', 'max:4096'],
            'is_active'   => ['nullable', 'boolean'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'page'        => ['required', 'in:home'],
        ]);

        $banner->fill([
            'title'       => $data['title'],
            'subtitle'    => $data['subtitle'] ?? null,
            'button_text' => $data['button_text'] ?? null,
            'button_url'  => $data['button_url'] ?? null,
            'is_active'   => (bool) ($data['is_active'] ?? false),
            'sort_order'  => (int) ($data['sort_order'] ?? 0),
            'page'        => $data['page'],
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image) $this->media->delete($banner->image);
            $banner->image = $this->media->store($request->file('image'), 'banners', config('cstees.media.banner_resize'));
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner saved.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $banner = Banner::findOrFail($id);
        if ($banner->image) $this->media->delete($banner->image);
        $banner->delete();

        return back()->with('success', 'Banner deleted.');
    }

    public function updateSort(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order'   => ['required', 'array'],
            'order.*' => ['integer', 'exists:banners,id'],
        ]);

        foreach ($data['order'] as $position => $id) {
            Banner::where('id', $id)->update(['sort_order' => $position]);
        }

        return response()->json(['ok' => true]);
    }
}
