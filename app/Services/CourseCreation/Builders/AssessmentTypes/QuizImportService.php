<?php

namespace App\Services\CourseCreation\Builders\AssessmentTypes;

use App\Imports\QuizzesImport;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class QuizImportService {
    public function importFile($filePath): array
    {
        $dbQuestions = [];
        $errors = [];
        try {
            $import = new QuizzesImport();

            Excel::import($import, $filePath);

            $questions = $import->getQuizzes();

            $dbQuestions = $this->normalizeForDataBase($questions);

        } catch (\Exception $e) {
            $errors = $e->getMessage();
        } finally {
            File::delete($filePath);
        }
        return [
            'errors' => $errors,
            'dbQuestions' => $dbQuestions,
        ];
    }

    public function normalizeForDataBase(array $questions): array
    {
        $normalized = [];

        foreach ($questions as $question) {
            $options = [];

            foreach (['option_1', 'option_2', 'option_3', 'option_4'] as $index => $optionKey) {
                if ($question[$optionKey] !== '') {
                    $options[] = [
                        'content' => $question[$optionKey],
                        'is_correct' => in_array($index + 1, $question['correct_answer']),
                        'explanation' => $question['explanation_' . $optionKey] ?? ''
                    ];
                }
            }

            $normalized[] = [
                'content' => $question['content'],
                'type' => $question['type'],
                'question_options' => $options,
            ];
        }

        return $normalized;
    }
}
