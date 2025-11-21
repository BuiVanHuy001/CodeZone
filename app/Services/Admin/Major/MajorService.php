<?php

namespace App\Services\Admin\Major;

use App\Models\ClassRoom;
use App\Models\InstructorProfile;
use App\Models\Major;
use App\Models\StudentProfile;
use App\Services\Cache\AcademicCache;
use App\Traits\HasCodeNormalization;
use Illuminate\Support\Facades\DB;

class MajorService {
    use HasCodeNormalization;

    public function getById(int $id): ?Major
    {
        return AcademicCache::getCachedMajorsOnly()->firstWhere('id', $id);
    }

    public function store(array $data): Major
    {
        return Major::create([
            'name' => $data['name'],
            'code' => $this->normalizeCode($data['code']),
            'faculty_id' => $data['faculty_id'],
        ]);
    }

    public function delete(int $id): bool
    {
        return Major::destroy($id) > 0;
    }

    public function transferAndDelete(int $sourceMajorId, int $targetMajorId): void
    {
        DB::transaction(function () use ($sourceMajorId, $targetMajorId) {
            ClassRoom::where('major_id', $sourceMajorId)
                     ->update(['major_id' => $targetMajorId]);

            StudentProfile::where('major_id', $sourceMajorId)
                          ->update(['major_id' => $targetMajorId]);

            InstructorProfile::where('major_id', $sourceMajorId)
                             ->update(['major_id' => $targetMajorId]);

            Major::findOrFail($sourceMajorId)->delete();
        });
    }

    public function update(int|string $id, array $data): Major
    {
        $major = Major::findOrFail($id);

        $major->update([
            'name' => $data['name'],
            'code' => $this->normalizeCode($data['code']),
            'slug' => $data['slug'],
            'faculty_id' => $data['faculty_id'],
        ]);

        return $major;
    }
}
