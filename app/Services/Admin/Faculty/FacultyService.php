<?php

namespace App\Services\Admin\Faculty;

use App\Models\Faculty;
use App\Models\Major;
use App\Services\Cache\AcademicCache;
use App\Traits\HasCodeNormalization;
use Illuminate\Support\Facades\DB;

class FacultyService {
    use HasCodeNormalization;

    public function store(array $data): Faculty
    {
        return Faculty::create([
            'name' => mb_strtoupper($data['name'], 'UTF-8'),
            'code' => $this->normalizeCode($data['code']),
            'slug' => $data['slug'],
        ]);
    }

    public function update(string|int $facultyId, array $data): Faculty
    {
        $faculty = Faculty::findOrFail($facultyId);

        $faculty->update([
            'name' => mb_strtoupper($data['name'], 'UTF-8'),
            'code' => $this->normalizeCode($data['code']),
        ]);

        return $faculty;
    }

    public function getById(int|string $id): ?Faculty
    {
        return AcademicCache::getCachedFacultiesWithMajors()->firstWhere('id', $id);
    }

    public function delete(int $id): bool
    {
        return Faculty::destroy($id) > 0;
    }

    public function transferAndDelete(int $sourceFacultyId, int $targetFacultyId): void
    {
        DB::transaction(function () use ($sourceFacultyId, $targetFacultyId) {
            Major::where('faculty_id', $sourceFacultyId)
                 ->update(['faculty_id' => $targetFacultyId]);

            Faculty::findOrFail($sourceFacultyId)->delete();
        });
    }
}
