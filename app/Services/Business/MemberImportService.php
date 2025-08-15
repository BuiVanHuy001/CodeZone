<?php

namespace App\Services\Business;

use App\Imports\MemberImport;
use App\Models\StudentProfile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

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
            'failures' => $import->failures(),
        ];
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
