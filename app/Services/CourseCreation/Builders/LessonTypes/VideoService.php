<?php

namespace App\Services\CourseCreation\Builders\LessonTypes;

use getID3;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VideoService {
    public function getDuration(string $absolutePath): int
    {
        $getID3 = new getID3;
        $info = $getID3->analyze($absolutePath);
        return (int)($info['playtime_seconds'] ?? 0);
    }

    public function storeVideo($video): array
    {
        $storedVideoRelPath = $video->storeAs(
            path: 'course/videos',
            options: 'public',
            name: $video->getFileName()
        );

        $storedVideoAbsPath = $this->getVideoAbsPath($storedVideoRelPath);

        $duration = $this->getDuration(Storage::disk('public')->path($storedVideoRelPath));

        File::delete($video->getRealPath());

        $savedFileName = basename($storedVideoRelPath);
        return [
            'videoFileName' => $savedFileName,
            'duration' => $duration,
            'storedVideoAbsPath' => $storedVideoAbsPath,
        ];
    }

    private function getVideoAbsPath(string $name): string
    {
        return Storage::url($name);
    }

    public function destroyVideo(string $relPath): void
    {
        if (Storage::disk('local')->exists('livewire-tmp/' . $relPath)) {
            Storage::disk('local')->delete('livewire-tmp/' . $relPath);
        }

        if (Storage::disk('public')->exists('course/videos/' . $relPath)) {
            Storage::disk('public')->delete('course/videos/' . $relPath);
        }
    }
}
