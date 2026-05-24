<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadsFiles
{
    /**
     * Upload a file and return the path.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string|null $oldPath
     * @param string $disk
     * @return string
     */
    protected function uploadFile(UploadedFile $file, string $folder, ?string $oldPath = null, string $disk = 'public'): string
    {
        if ($oldPath) {
            Storage::disk($disk)->delete($oldPath);
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($folder, $filename, $disk);
    }

    /**
     * Delete a file from disk.
     *
     * @param string|null $path
     * @param string $disk
     * @return void
     */
    protected function deleteFile(?string $path, string $disk = 'public'): void
    {
        if ($path) {
            Storage::disk($disk)->delete($path);
        }
    }
}
