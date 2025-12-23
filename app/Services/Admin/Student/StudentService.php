<?php

namespace App\Services\Admin\Student;

use App\DTOs\Student\StudentDetailDTO;
use App\Factories\InternalStudentFactory;
use App\Imports\StudentImport;
use App\Livewire\Admin\Student\ImportResult;
use App\Models\ClassRoom;
use App\Models\User;
use App\Services\Client\Course\Catalog\CourseDecorator;
use App\Services\Client\Course\LearningService;
use App\Traits\HasNumberFormat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Spatie\Permission\Models\Role;

class StudentService {
    use HasNumberFormat;

    private static ?Collection $studentsData = null;

    private function getAllStudents(): Collection
    {
        if (self::$studentsData !== null) {
            return self::$studentsData;
        }

        self::$studentsData = Role::findByName('student')
                                  ->users()
                                  ->with('studentProfile')
                                  ->get();

        return self::$studentsData;
    }

    public function getCharts(): array
    {
        $this->getAllStudents();
        return [
            'totalStudents' => $this->getTotalStudents(),
            'internalDistribution' => $this->getInternalDistribution(),
            'externalDistribution' => $this->getExternalDistribution()
        ];
    }

    private function getTotalStudents(): array
    {
        $internalCount = self::$studentsData?->filter(function ($student) {
            return $student->studentProfile &&
                $student->studentProfile->student_type === 'internal' &&
                $student->status === 'active';
        })->count();

        $externalCount = self::$studentsData?->filter(function ($student) {
            return $student->studentProfile &&
                $student->studentProfile->student_type === 'external' &&
                $student->status === 'active';
        })->count();

        return [
            'title' => 'Tổng số sinh viên',
            'labels' => ['Sinh viên chính quy', 'Sinh viên bên ngoài'],
            'data' => [$internalCount, $externalCount]
        ];
    }

    private function getInternalDistribution(): array
    {
        $internalStudents = self::$studentsData?->filter(function ($student) {
            return $student->studentProfile &&
                $student->studentProfile->student_type === 'internal';
        });

        $statusCounts = collect(array_keys(User::getStatusesByRole('student')))->map(function ($status) use ($internalStudents) {
            return $internalStudents->where('status', $status)->count();
        })->values()->toArray();

        return [
            'title' => 'Phân bổ sinh viên chính quy',
            'labels' => array_values(User::getStatusesByRole('student')),
            'data' => $statusCounts,
        ];
    }

    private function getExternalDistribution(): array
    {
        $externalStudents = self::$studentsData?->filter(function ($student) {
            return $student->studentProfile &&
                $student->studentProfile->student_type === 'external';
        });

        $statusCounts = collect(array_keys(User::getStatusesByRole('student')))->map(function ($status) use ($externalStudents) {
            return $externalStudents->where('status', $status)->count();
        })->values()->toArray();

        return [
            'title' => 'Phân bổ sinh viên liên kết',
            'labels' => array_values(User::getStatusesByRole('student')),
            'data' => $statusCounts,
        ];
    }

    public function getInternalStudentsQuery(array $filters = []): Builder
    {
        return User::role('student')
                   ->with(['studentProfile.major.faculty', 'studentProfile.classRoom'])
                   ->whereHas('studentProfile', function ($q) use ($filters) {
                       $q->where('student_type', 'internal');

                       if (!empty($filters['faculty_id'])) {
                           $q->whereHas('classRoom.major', function ($subQ) use ($filters) {
                               $subQ->where('faculty_id', $filters['faculty_id']);
                           });
                       }

                       if (!empty($filters['major_id'])) {
                           $q->whereHas('classRoom', function ($subQ) use ($filters) {
                               $subQ->where('major_id', $filters['major_id']);
                           });
                       }

                       if (!empty($filters['class_room_id'])) {
                           $q->where('class_room_id', $filters['class_room_id']);
                       }
                   });
    }

    public function getExternalStudentsQuery(): Builder
    {
        return User::role('student')
                   ->with(['studentProfile'])
                   ->whereHas('studentProfile', function ($query) {
                       $query->where('student_type', 'external');
                   });
    }

    public function importStudent($files): ImportResult
    {
        $result = new ImportResult();
        DB::transaction(function () use ($files, $result) {
            try {
                foreach ($files as $file) {
                    $this->processSingleFile($file, $result);
                    if (file_exists($file->getRealPath())) {
                        unlink($file->getRealPath());
                    }
                }
            } catch (\Exception $e) {
                throw $e;
            }
        });

        return $result;
    }

    private function processSingleFile($file, ImportResult $result): void
    {
        $fileName = $file->getClientOriginalName();

        try {
            $import = new StudentImport();
            Excel::import($import, $file->getRealPath());

            $importedStudents = $import->getImportedStudents();
            $createdModels = InternalStudentFactory::createMany($importedStudents);

            $createdModels->map(function ($student) {
                $student->load(['studentProfile', 'studentProfile.major.faculty', 'studentProfile.classRoom']);
            });

            $result->addSuccess($createdModels->toArray(), $fileName);

            if ($importErrors = $import->getErrors()) {
                $result->addError($fileName, $importErrors);
            }

        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $friendlyMessage = $this->parseDuplicateError($e->getMessage());
                $result->addError($fileName, $friendlyMessage);
            } else {
                \Log::error($e->getMessage());
                $result->addError($fileName, "Lỗi cơ sở dữ liệu không xác định.");
            }

        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $row = $failure->row();
                $errors = $failure->errors();
                foreach ($errors as $error) {
                    $errorMessages[] = "Dòng {$row}: {$error}";
                }
            }
            $result->addError($fileName, $errorMessages);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $result->addError($fileName, "Lỗi xử lý file: " . $e->getMessage());
        }
    }

    private function parseDuplicateError(string $errorMessage): string
    {
        preg_match("/Duplicate entry '(.*?)' for key/", $errorMessage, $matches);
        $duplicateValue = $matches[1] ?? 'này';

        if (str_contains($errorMessage, 'students_student_code_unique')) {
            return "Mã sinh viên '{$duplicateValue}' đã tồn tại trên hệ thống.";
        }

        if (str_contains($errorMessage, 'users_email_unique')) {
            return "Email '{$duplicateValue}' đã được sử dụng bởi người khác.";
        }

        return "Dữ liệu '{$duplicateValue}' đã tồn tại trong hệ thống.";
    }

    public function getStudentDetail(string $userId): ?StudentDetailDTO
    {
        $student = User::with([
            'studentProfile.major.faculty',
            'studentProfile.classRoom',
        ])->find($userId);

        if (!$student) return null;

        return StudentDetailDTO::fromModel($student);
    }

    public function updateStudent(string $id, array $data): User
    {
        $student = User::findOrFail($id);

        DB::transaction(function () use ($student, $data) {
            $student->update([
                'name' => $data['name'],
                'status' => $data['status'],
            ]);

            $majorId = ClassRoom::find($data['class_room_id'])?->major_id;

            $student->studentProfile->updateOrCreate(
                ['user_id' => $student->id], [
                'student_code' => $data['student_code'],
                'gender' => $data['gender'],
                'dob' => $data['dob'],
                'class_room_id' => $data['class_room_id'] ?? null,
                'major_id' => $majorId,
            ]);
        });

        return $student;
    }

    public function deleteStudentAvatar(User $student): bool
    {
        $currentAvatarPath = $student->avatar;

        $isExternalLink = Str::startsWith($currentAvatarPath, ['http://', 'https://']);

        if (!$isExternalLink) {
            if (\Storage::disk('public')->exists($currentAvatarPath)) {
                \Storage::disk('public')->delete($currentAvatarPath);
            }
        }

        return $student->update(['avatar' => null]);
    }
}
