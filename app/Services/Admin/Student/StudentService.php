<?php

namespace App\Services\Admin\Student;

use App\Factories\InternalStudentFactory;
use App\Imports\StudentImport;
use App\Models\User;
use App\Traits\HasNumberFormat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Spatie\Permission\Models\Role;

class StudentService {
    use HasNumberFormat;

    private Collection $studentsData;

    public function __construct()
    {
        $this->studentsData = Role::findByName('student')
                                  ->users()
                                  ->with(['studentProfile', 'studentProfile.major', 'studentProfile.major.faculty', 'studentProfile.classRoom'])
                                  ->get();
    }

    public function getCharts(): array
    {
        return [
            'totalStudents' => $this->getTotalStudents(),
            'internalDistribution' => $this->getInternalDistribution(),
            'externalDistribution' => $this->getExternalDistribution()
        ];
    }

    private function getTotalStudents(): array
    {
        $internalCount = $this->studentsData->filter(function ($student) {
            return $student->studentProfile &&
                $student->studentProfile->student_type === 'internal' &&
                $student->status === 'active';
        })->count();

        $externalCount = $this->studentsData->filter(function ($student) {
            return $student->studentProfile &&
                $student->studentProfile->student_type === 'external' &&
                $student->status === 'active';
        })->count();

        return [
            'title' => 'Total Students',
            'labels' => ['Internal students', 'External students'],
            'data' => [$internalCount, $externalCount]
        ];
    }

    private function getInternalDistribution(): array
    {
        $internalStudents = $this->studentsData->filter(function ($student) {
            return $student->studentProfile &&
                $student->studentProfile->student_type === 'internal';
        });

        $statusCounts = collect(User::$STATUSES)->map(function ($status) use ($internalStudents) {
            return $internalStudents->where('status', $status)->count();
        })->values()->toArray();

        return [
            'title' => 'Internal Distribution',
            'labels' => array_map('ucfirst', User::$STATUSES),
            'data' => $statusCounts,
        ];
    }

    private function getExternalDistribution(): array
    {
        $externalStudents = $this->studentsData->filter(function ($student) {
            return $student->studentProfile &&
                $student->studentProfile->student_type === 'external';
        });

        $statusCounts = collect(User::$STATUSES)->map(function ($status) use ($externalStudents) {
            return $externalStudents->where('status', $status)->count();
        })->values()->toArray();

        return [
            'title' => 'External Distribution',
            'labels' => array_map('ucfirst', User::$STATUSES),
            'data' => $statusCounts,
        ];
    }

    public function getStudentsData(): array
    {
        return [
            'internal' => $this->getInternalStudentTable(),
            'external' => $this->getExternalStudentTable()
        ];
    }

    private function getInternalStudentTable(): Collection
    {
        return $this->studentsData->filter(function ($student) {
            return $student->studentProfile &&
                $student->studentProfile->student_type === 'internal';
        })->map(function ($student) {
            app(StudentPreparation::class)->decorateData($student);
            return $student;
        });
    }

    private function getExternalStudentTable(): Collection
    {
        return $this->studentsData->filter(function ($student) {
            return $student->studentProfile &&
                $student->studentProfile->student_type === 'external';
        })->map(function ($student) {
            app(StudentPreparation::class)->decorateData($student);
            return $student;
        });
    }

    public function importStudent($files): array
    {
        $totalImported = 0;
        $allErrors = [];
        $fileResults = [];

        foreach ($files as $file) {
            try {
                $fileName = $file->getClientOriginalName();
                $filePath = $file->getRealPath();

                $import = new StudentImport();
                Excel::import($import, $filePath);

                $importedStudents = $import->getImportedStudents();

                InternalStudentFactory::createMany($importedStudents);

                $importedCount = count($importedStudents);
                $errors = $import->getErrors();
                $totalImported += $importedCount;

                if (!empty($errors)) {
                    $allErrors = array_merge($allErrors, $errors);
                }

                $fileResults[] = [
                    'file' => $fileName,
                    'imported' => $importedCount,
                    'errors' => count($errors),
                ];

            } catch (ValidationException $e) {
                $failures = $e->failures();
                foreach ($failures as $failure) {
                    $allErrors[] = "File: {$fileName}, Row {$failure->row()}: " . implode(', ', $failure->errors());
                }
            } catch (\Exception $e) {
                $allErrors[] = "File: {$fileName} - Error: " . $e->getMessage();
            }
            \File::delete($file->getRealPath());
        }

        return [
            'totalImported' => $totalImported,
            'errors' => $allErrors,
            'fileResults' => $fileResults,
        ];
    }
}
