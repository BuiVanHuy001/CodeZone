<?php

namespace App\Services\Admin\Classroom;

use App\Models\ClassRoom;
use App\Models\StudentProfile;
use App\Services\Cache\AcademicCache;
use App\Traits\HasCodeNormalization;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ClassroomService {
    use HasCodeNormalization;

    public function getAll(): Collection
    {
        return AcademicCache::getCachedClassroomList();
    }

    public function getById(int $id): ?ClassRoom
    {
        return AcademicCache::getCachedClassroomDetail($id);
    }

    public function update(int|string $id, array $data): ClassRoom
    {
        $classroom = ClassRoom::findOrFail($id);

        $classroom->update([
            'name' => $data['name'],
            'code' => $this->normalizeCode($data['code']),
            'major_id' => $data['major_id'],
        ]);

        return $classroom;
    }

    public function getTransferableClasses(int|string $currentClassId, int $majorId): Collection
    {
        return ClassRoom::query()
                        ->select(['id', 'name', 'code'])
                        ->where('major_id', $majorId)
                        ->where('id', '!=', $currentClassId)
                        ->latest()
                        ->get();
    }

    public function removeStudentFromClass(string|int $studentProfileId): void
    {
        $profile = StudentProfile::findOrFail($studentProfileId);
        $profile->update(['class_room_id' => null]);
    }

    public function transferStudent(int|string $studentProfileId, int $targetClassId): void
    {
        $profile = StudentProfile::findOrFail($studentProfileId);
        $profile->update(['class_room_id' => $targetClassId]);
    }

    public function getUnassignedStudents(?int $majorId): Collection
    {
        return StudentProfile::with('user')
                             ->where('student_type', 'internal')
                             ->whereNull('class_room_id')
                             ->get();
    }

    public function store(array $data, array $studentIds = []): ClassRoom
    {
        return DB::transaction(function () use ($data, $studentIds) {
            $classroom = ClassRoom::create([
                'name' => $data['name'],
                'code' => $this->normalizeCode($data['code']),
                'major_id' => $data['major_id'],
            ]);

            if (!empty($studentIds)) {
                StudentProfile::whereIn('user_id', $studentIds)
                              ->update([
                                  'class_room_id' => $classroom->id,
                                  'major_id' => $data['major_id']
                              ]);
            }

            return $classroom;
        });
    }

    public function getStudentsForEnrollment(int $majorId, int $currentClassId): Collection
    {
        return StudentProfile::with('user')
                             ->where('student_type', 'internal')
            // Nhóm điều kiện quan trọng nhất
                             ->where(function ($q) use ($majorId, $currentClassId) {

                // TRƯỜNG HỢP 1: Sinh viên CHƯA CÓ LỚP (Theo yêu cầu của bạn)
                // Lấy tất cả SV chưa có lớp, BẤT KỂ major_id là gì (null, khác ngành, cùng ngành đều lấy)
                $q
                    ->whereNull('class_room_id')

                    // TRƯỜNG HỢP 2: Sinh viên ĐANG Ở LỚP KHÁC (để chuyển lớp)
                    // Trường hợp này thì BẮT BUỘC phải CÙNG NGÀNH mới cho chuyển
                    ->orWhere(function ($subQ) use ($majorId, $currentClassId) {
                        $subQ
                            ->where('major_id', $majorId)
                            ->where('class_room_id', '!=', $currentClassId);
                    });
            })
                             ->whereHas('user')
                             ->latest('created_at')
                             ->get()
                             ->map(function ($profile) use ($majorId) {
                                 return [
                                     'id' => $profile->user_id,
                                     'name' => $profile->user->name,
                                     'email' => $profile->user->email,
                                     'code' => $profile->student_code,
                                     // Chú ý: kiểm tra lại tên hàm getAvatarPath() trong model User của bạn
                                     'avatar' => $profile->user->getAvatarPath(),
                                     'current_class_code' => $profile->classRoom ? $profile->classRoom->code : null,

                                     // Cờ báo chưa có ngành
                                     'no_major' => is_null($profile->major_id),

                                     'is_diff_major' => $profile->major_id && $profile->major_id != $majorId,
                                 ];
                             });
    }

    public function assignStudents(int $classId, array $studentIds): void
    {
        if (empty($studentIds)) return;

        $classroom = ClassRoom::find($classId);
        if (!$classroom) return;

        StudentProfile::whereIn('user_id', $studentIds)
                      ->update([
                          'class_room_id' => $classId,
                          'major_id' => $classroom->major_id
                      ]);
    }
}
