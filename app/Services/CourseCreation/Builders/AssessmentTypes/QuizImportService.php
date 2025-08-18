<?php

namespace App\Services\CourseCreation\Builders\AssessmentTypes;

use App\Imports\QuizzesImport;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class QuizImportService {
    public function importFile($filePath): array
    {
        $import = new QuizzesImport();
        Excel::import($import, $filePath);
        File::delete($filePath);
        return $import->getQuizzes();
    }
}
