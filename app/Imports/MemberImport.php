<?php

namespace App\Imports;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MemberImport implements ToCollection, SkipsOnError, SkipsOnFailure, WithHeadingRow, WithValidation {
    use SkipsErrors, SkipsFailures;

    public function __construct()
    {
        HeadingRowFormatter::default('none');

    }

    private array $members = [];

    public function collection(Collection $collection): void
    {
        $this->members = $collection->map(function ($row) {
            return $row;
        })->toArray();
    }

    public function getMembers(): array
    {
        return $this->members;
    }

    public function prepareForValidation(array $row): array
    {
        if (!empty($row['DATE OF BIRTH'])) {
            $row['DATE OF BIRTH'] = $this->parseDob($row['DATE OF BIRTH']);
        }
        if (!empty($row['GENDER'])) {
            $row['GENDER'] = $this->parseGender($row['GENDER']);
        }

        return $row;
    }

    private function parseDob(string|int $dob): string
    {
        if (is_numeric($dob)) {
            return Carbon::parse(Date::excelToDateTimeObject($dob))->format('Y-m-d');
        }
        return Carbon::parse($dob)->format('Y-m-d');
    }

    private function parseGender(string $gender): ?string
    {
        $gender = strtolower(trim($gender));
        if (in_array($gender, ['nam', 'male'])) {
            return 'male';
        } elseif (in_array($gender, ['nữ', 'nu', 'female'])) {
            return 'female';
        } else {
            return null;
        }
    }

    public function rules(): array
    {
        return [
            '*.MAIL' => 'required|email',
            '*.FULL NAME' => 'required|string|max:255',
            '*.PASSWORD' => 'required|min:8',
            '*.DATE OF BIRTH' => 'nullable|date_format:Y-m-d',
            '*.AVATAR URL' => 'nullable|url',
            '*.GENDER' => 'nullable|in:male,female',
        ];
    }
}
