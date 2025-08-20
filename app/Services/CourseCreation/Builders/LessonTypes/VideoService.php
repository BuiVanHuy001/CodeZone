<?php

namespace App\Services\CourseCreation\Builders\LessonTypes;

use getID3;

class VideoService {
    public function getDuration(string $absolutePath): int
    {
        $getID3 = new getID3;
        $info = $getID3->analyze($absolutePath);
        return (int)($info['playtime_seconds'] ?? 0);
    }
}
