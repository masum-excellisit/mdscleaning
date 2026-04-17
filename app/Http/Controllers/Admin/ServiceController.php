<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\MediaService;
use App\Services\SlugService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(
        protected MediaService $media,
        protected SlugService $slugService,
    ) {}

    public function index(): View
    {
        $services = Service::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        $service = new Service(['is_active' => true, 'sort_order' => 0]);
        return view('admin.services.create', compact('service'));
    }

    public function edit(int $id): View
    {
        $service = Service::findOrFail($id);
        return view('admin.services.create', compact('service'));
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->save($request, new Service());
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return $this->save($request, Service::findOrFail($id));
    }

    protected function save(Request $request, Service $service): RedirectResponse
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:200'],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'description'      => ['nullable', 'string'],
            'features'         => ['nullable', 'string'],
            'icon_class'       => ['nullable', 'string', 'max:100'],
            'image'            => ['nullable', 'image', 'max:4096'],
            'is_active'        => ['nullable', 'boolean'],
            'sort_order'       => ['nullable', 'integer', 'min:0'],
            'meta_title'       => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        $service->fill([
            'title'            => $data['title'],
            'slug'             => $service->slug ?: $this->slugService->generate($data['title'], 'services'),
            'excerpt'          => $data['excerpt'] ?? null,
            'description'      => $data['description'] ?? null,
            'features'         => $this->parseFeatures($data['features'] ?? null),
            'icon_class'       => $data['icon_class'] ?? null,
            'is_active'        => (bool) ($data['is_active'] ?? false),
            'sort_order'       => (int) ($data['sort_order'] ?? 0),
            'meta_title'       => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
        ]);

        if ($request->hasFile('image')) {
            if ($service->image) $this->media->delete($service->image);
            $service->image = $this->media->store($request->file('image'), 'services', [800, 600]);
        }

        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'Service saved.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);
        if ($service->image) $this->media->delete($service->image);
        $service->delete();

        return back()->with('success', 'Service deleted.');
    }

    public function toggle(int $id): JsonResponse
    {
        $service = Service::findOrFail($id);
        $service->update(['is_active' => ! $service->is_active]);

        return response()->json(['is_active' => $service->is_active]);
    }

    private function parseFeatures(?string $raw): ?array
    {
        if (! $raw) return null;
        return array_values(array_filter(array_map('trim', explode("\n", $raw))));
    }
}
