<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(protected MediaService $media) {}

    public function index(Request $request): View
    {
        $q = Media::query();
        if ($s = $request->string('q')->toString()) {
            $q->where('file_name', 'like', "%{$s}%");
        }
        if ($type = $request->string('type')->toString()) {
            $q->where('file_type', $type);
        }
        $media = $q->latest()->paginate(48)->withQueryString();

        return view('admin.media.index', compact('media'));
    }

    public function upload(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'files'   => ['required', 'array'],
            'files.*' => ['file', 'max:4096', 'mimes:jpg,jpeg,png,webp,gif,svg'],
        ]);

        $uploaded = [];
        foreach ($request->file('files', []) as $file) {
            $path = $this->media->store($file, 'library', null, true);
            $uploaded[] = Media::latest()->first()?->only(['id', 'file_name', 'file_path', 'mime_type']);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['ok' => true, 'count' => count($uploaded), 'files' => $uploaded]);
        }

        return back()->with('success', count($uploaded) . ' file(s) uploaded.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $file = Media::findOrFail($id);
        $this->media->delete($file->file_path);
        $file->delete();

        return back()->with('success', 'File removed.');
    }

    public function picker(Request $request): View
    {
        $media = Media::where('file_type', 'image')->latest()->paginate(36);
        return view('admin.media.picker', compact('media'));
    }
}
