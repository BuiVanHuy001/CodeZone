<?php

namespace App\Services\Business;

use App\Imports\MemberImport;
use App\Models\StudentProfile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class MemberImportService {
    public function importFile($filePath): array
    {
        $import = new MemberImport();
        Excel::import($import, $filePath);

        $members = $import->getMembers();
        File::delete($filePath);

        $normalizedMembers = $this->normalizeForDatabase($members);

        return [
            'displayMembers' => $members,
            'dbMembers' => $normalizedMembers,
            'errors' => $import->errors(),
            'failures' => $this->formatFailures($import->failures())
        ];
    }

    private function formatFailures(array|Collection $failures): array
    {
        return collect($failures)
            ->groupBy(fn($failure) => $failure->row())
            ->map(function ($failuresByRow, $row) {
                return [
                    'row' => $row,
                    'errors' => $failuresByRow->flatMap->errors()->all(),
                    'values' => $failuresByRow->flatMap->values()->all(),
                ];
            })
            ->values()
            ->toArray();
    }

    private function normalizeForDatabase(array $members): array
    {
        $normalized = [];

        foreach ($members as $member) {
            $newMember = [
                'addition_data' => []
            ];

            foreach ($member as $key => $value) {
                if (isset(StudentProfile::$DEFAULT_COLUMNS[$key])) {
                    $dbKey = StudentProfile::$DEFAULT_COLUMNS[$key];
                    $newMember[$dbKey] = $value;
                } else {
                    $newMember['addition_data'][$key] = $value;
                }
            }

            $normalized[] = $newMember;
        }

        return $normalized;
    }
}
