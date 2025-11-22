<?php

namespace App\Imports;

use App\Services\Cache\AcademicCache;
use App\Services\Cache\StudentCache;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation {
    private array $REQUIRED_COLUMNS = ['mssv', 'email', 'ho_va_ten', 'ngay_sinh', 'gioi_tinh', 'nganh', 'lop', 'nam_nhap_hoc',];

    public array $importedStudents = [];
    public array $errors = [];

    private $classrooms;
    private $majors;
    private $existingEmails;
    private $existingStudentCodes = [];

    public function __construct()
    {
        $this->classrooms = AcademicCache::getCachedClassroom();
        $this->majors = AcademicCache::getCachedMajorsOnly();
        $this->existingEmails = StudentCache::getExistingEmails();
        $this->existingStudentCodes = StudentCache::getExistingStudentCodes();
    }

    public function collection(Collection $collection): void
    {
        if ($collection->isEmpty()) {
            throw new \Exception("File Excel không có dữ liệu.");
        }

        $firstRow = $collection->first();
        \Log::info('StudentImport: First row data', $firstRow ? $firstRow->toArray() : []);

        $headers = array_keys($firstRow->toArray());

        $missing = array_diff($this->REQUIRED_COLUMNS, $headers);

        if (!empty($missing)) {
            $missingReadable = array_map(function ($key) {
                $map = [
                    'mssv' => 'MSSV',
                    'email' => 'Email',
                    'ho_va_ten' => 'Họ và tên',
                    'ngay_sinh' => 'Ngày sinh',
                    'gioi_tinh' => 'Giới tính',
                    'nganh' => 'Ngành',
                    'lop' => 'Lớp',
                    'nam_nhap_hoc' => 'Năm nhập học',
                ];
                return $map[$key] ?? $key;
            }, $missing);
            throw new \Exception("File Excel thiếu các cột: " . implode(', ', $missingReadable));
        }


        foreach ($collection as $index => $row) {
            $rowNumber = $index + 2;

            $email = $row['email'];
            $studentCode = $row['mssv'];
            $fullName = $row['ho_va_ten'];
            $classroomCode = $row['lop'];
            $majorName = $row['nganh'];
            $gender = $row['gioi_tinh'];
            $dobValue = $row['ngay_sinh'];
            $enrollmentYearValue = $row['nam_nhap_hoc'];
            $password = !empty($row['mat_khau']) ? $row['mat_khau'] : 'password123';

            try {
                if (isset($this->existingEmails[$email])) {
                    $this->errors[] = "Dòng {$rowNumber}: Email '{$email}' đã tồn tại trong hệ thống";
                    continue;
                }

                if (isset($this->existingStudentCodes[$studentCode])) {
                    $this->errors[] = "Dòng {$rowNumber}: Mã sinh viên '{$studentCode}' đã tồn tại trong hệ thống";
                    continue;
                }

                $classroomObj = $this->classrooms->where('code', $classroomCode)->first();
                if (!$classroomObj) {
                    $this->errors[] = "Dòng {$rowNumber}: Mã lớp '{$classroomCode}' không tìm thấy";
                    continue;
                }

                $majorNameNormalized = mb_strtolower(trim((string)$majorName));
                $majorObj = $this->majors->first(function ($m) use ($majorNameNormalized) {
                    return mb_strtolower(trim((string)($m->name ?? ''))) === $majorNameNormalized;
                });
                if (!$majorObj) {
                    $this->errors[] = "Dòng {$rowNumber}: Tên ngành '{$majorName}' không tìm thấy";
                    continue;
                }

                $this->importedStudents[] = [
                    'name' => $fullName,
                    'email' => $email,
                    'password' => $password,
                    'gender' => $gender,
                    'dob' => $dobValue,
                    'student_code' => $studentCode,
                    'classroom_id' => $classroomObj->id,
                    'major_id' => $majorObj->id,
                    'enrollment_year' => $enrollmentYearValue,
                    'student_type' => 'internal',
                ];

                $this->existingEmails[$email] = true;
                $this->existingStudentCodes[$studentCode] = true;

            } catch (\Exception $e) {
                $this->errors[] = "Dòng {$rowNumber}: " . $e->getMessage();
            }
        }
    }

    public function rules(): array
    {
        return [
            'ho_va_ten' => 'required|string|max:255',
            'email' => 'required|email',
            'mssv' => 'required|string',
            'lop' => 'required|string',
            'nganh' => 'required|string',
            'gioi_tinh' => 'nullable|boolean',
            'ngay_sinh' => 'nullable',
            'nam_nhap_hoc' => 'nullable',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'ho_va_ten.required' => 'Họ và tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'mssv.required' => 'Mã sinh viên (MSSV) không được để trống',
            'lop.required' => 'Mã lớp không được để trống',
            'nganh.required' => 'Tên ngành không được để trống',
        ];
    }

    public function prepareForValidation(array $data): array
    {
        if (isset($data['mssv']) && is_numeric($data['mssv'])) {
            $data['mssv'] = (string)$data['mssv'];
        }

        if (isset($data['ngay_sinh']) && is_numeric($data['ngay_sinh'])) {
            try {
                $data['ngay_sinh'] = Date::excelToDateTimeObject($data['ngay_sinh'])->format('Y-m-d');
            } catch (\Exception $e) {
                $data['ngay_sinh'] = null;
            }
        }

        if (isset($data['nam_nhap_hoc']) && is_numeric($data['nam_nhap_hoc'])) {
            try {
                $data['nam_nhap_hoc'] = Date::excelToDateTimeObject($data['nam_nhap_hoc'])->format('Y-m-d');
            } catch (\Exception $e) {
                $data['nam_nhap_hoc'] = null;
            }
        }

        $genderString = strtolower(trim($data['gioi_tinh'] ?? ''));

        if (in_array($genderString, ['nữ', 'nu', 'female'])) {
            $data['gioi_tinh'] = true;
        } elseif (in_array($genderString, ['nam', 'male'])) {
            $data['gioi_tinh'] = false;
        } else {
            $data['gioi_tinh'] = null;
        }

        $data['email'] = strtolower(trim($data['email'] ?? ''));
        $data['ho_va_ten'] = trim($data['ho_va_ten'] ?? '');
        $data['lop'] = trim($data['lop'] ?? '');
        $data['nganh'] = trim($data['nganh'] ?? '');

        return $data;
    }

    public function getImportedStudents(): array
    {
        return $this->importedStudents;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
