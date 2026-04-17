<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class MediaService
{
    /**
     * Store an uploaded image to the public disk under the given subfolder
     * and (optionally) resize it. Returns the relative storage path.
     *
     * @param  UploadedFile  $file
     * @param  string        $folder    e.g. "products", "blogs", "banners"
     * @param  array|null    $resize    [width, height] to fit inside, or null = keep original
     * @param  bool          $recordInLibrary  also record in the media table
     */
    public function store(UploadedFile $file, string $folder = 'uploads', ?array $resize = null, bool $recordInLibrary = false): string
    {
        $folder = trim($folder, '/');
        $ext    = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $name   = Str::random(24) . '.' . $ext;
        $path   = "{$folder}/{$name}";

        if ($resize && in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp', 'image/gif'])) {
            try {
                $manager = new ImageManager(new GdDriver());
                $img     = $manager->read($file->getRealPath())->scaleDown($resize[0], $resize[1]);
                $encoded = (string) $img->encodeByExtension($ext, quality: 88);
                Storage::disk('public')->put($path, $encoded);
            } catch (\Throwable $e) {
                // fall back to raw upload
                Storage::disk('public')->putFileAs($folder, $file, $name);
            }
        } else {
            Storage::disk('public')->putFileAs($folder, $file, $name);
        }

        if ($recordInLibrary) {
            Media::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => str_starts_with($file->getMimeType() ?? '', 'image/') ? 'image' : 'document',
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType() ?? 'application/octet-stream',
                'user_id'   => auth()->id(),
            ]);
        }

        return $path;
    }

    /**
     * Delete a stored file (best-effort). Accepts either a relative storage path
     * (e.g. "products/abc.jpg") or null/empty (no-op).
     */
    public function delete(?string $path): bool
    {
        if (! $path) return false;
        if (str_starts_with($path, 'http') || str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) {
            return false; // never delete static assets
        }
        try {
            return Storage::disk('public')->delete($path);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Return a public URL for a stored path.
     */
    public function url(?string $path): ?string
    {
        if (! $path) return null;
        if (str_starts_with($path, 'http')) return $path;
        if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) {
            return asset(ltrim($path, '/'));
        }
        return Storage::url($path);
    }
}
