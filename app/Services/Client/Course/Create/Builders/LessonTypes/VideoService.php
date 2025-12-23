<?php

namespace App\Services\Client\Course\Create\Builders\LessonTypes;

use getID3;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class VideoService {
    public function getDuration(string $absolutePath): int
    {
        try {
            $getID3 = new getID3;
            $info = $getID3->analyze($absolutePath);
            return (int)($info['playtime_seconds'] ?? 0);
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function storeDraftVideo(UploadedFile $video): array
    {
        $fileName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();

        $relPath = $video->storeAs(
            path: config('filesystems.paths.courses.videos.draft'),
            name: $fileName,
            options: 'public'
        );

        $absPathOnDisk = Storage::disk('public')->path($relPath);
        $duration = $this->getDuration($absPathOnDisk);

        return [
            'videoFileName' => $fileName,
            'duration' => $duration,
            'storedVideoAbsPath' => Storage::url($relPath),
            'status' => 'draft'
        ];
    }

    public function storePendingVideo(string $fileName): bool
    {
        $draftPath = config('filesystems.paths.courses.videos.draft') . '/' . $fileName;
        $pendingPath = config('filesystems.paths.courses.videos.pending') . '/' . $fileName;

        if (Storage::disk('public')->exists($draftPath)) {
            return Storage::disk('public')->move($draftPath, $pendingPath);
        }

        return false;
    }

    public function approveVideo(string $fileName): bool
    {
        $pendingPath = config('filesystems.paths.courses.videos.pending') . '/' . $fileName;
        $approvedPath = config('filesystems.paths.courses.videos.published') . '/' . $fileName;

        if (Storage::disk('public')->exists($pendingPath)) {
            return Storage::disk('public')->move($pendingPath, $approvedPath);
        }

        return false;
    }

    public function destroyVideo(string|TemporaryUploadedFile $fileName): void
    {
        if (!is_string($fileName)) {
            $fileName->delete();
            return;
        }

        Storage::disk('public')->delete([
            config('filesystems.paths.courses.videos.draft') . '/' . $fileName,
            config('filesystems.paths.courses.videos.pending') . '/' . $fileName,
            config('filesystems.paths.courses.videos.published') . '/' . $fileName,
        ]);
    }
}
