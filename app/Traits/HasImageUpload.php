<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasImageUpload
{
    /**
     * Handle image upload and return stored path.
     *
     * @param  \Illuminate\Http\UploadedFile|null  $image
     * @param  string  $folder
     * @param  string  $disk
     * @return string|null
     */
    public function uploadImage(?UploadedFile $image, string $folder = 'images', string $disk = 'public'): ?string
    {
        if (!$image) return null;

        return $image->store($folder, $disk);
    }

    /**
     * Delete an existing image from storage.
     *
     * @param string|null $path
     * @param string $disk
     * @return void
     */
    public function deleteImage(?string $path, string $disk = 'public'): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}
