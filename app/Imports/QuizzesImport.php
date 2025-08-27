<?php

namespace App\Imports;

use AllowDynamicProperties;
use App\Models\AssessmentQuestion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuizzesImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    private array $quizzes = [];

    /**
     * @throws \Exception
     */
    public function collection(Collection $collection): void
    {
        if ($collection->isEmpty()) {
            throw new \Exception("File Excel không có dữ liệu.");
        }

        $headers = array_keys($collection->first()->toArray());

        $required = AssessmentQuestion::$REQUIRED_COLUMNS;

        $missing = array_diff($required, $headers);

        if (!empty($missing)) {
            // Đổi key thành label đẹp từ EXPECTED_COLUMNS
            $missingLabels = array_map(fn($key) => AssessmentQuestion::$EXPECTED_COLUMNS[$key] ?? $key, $missing);

            throw new \Exception("File Excel thiếu các cột: " . implode(', ', $missingLabels));
        }

        $this->quizzes = $collection->map(function ($row) {
            return [
                'content' => $row['text_of_the_question'],
                'type' => $row['question_type'] ?? null,
                'option_1' => $row['option_1'],
                'explanation_option_1' => $row['explanation_option_1'] ?? '',
                'option_2' => $row['option_2'] ?? '',
                'explanation_option_2' => $row['explanation_option_2'] ?? '',
                'option_3' => $row['option_3'] ?? '',
                'explanation_option_3' => $row['explanation_option_3'] ?? '',
                'option_4' => $row['option_4'] ?? '',
                'explanation_option_4' => $row['explanation_option_4'] ?? '',
                'correct_answer' => $row['the_correct_option_choice'] ?? '',
            ];
        })->toArray();
    }


    public function getQuizzes(): array
    {
        return $this->quizzes;
    }

    public function isEmptyWhen(array $row): bool
    {
        return collect($row)->filter(function ($value) {
            if (is_null($value)) return false;
            if (is_array($value)) return !empty($value);
            return trim((string)$value) !== '';
        })->isEmpty();
    }

    public function prepareForValidation(array $row): array
    {
        if (!empty($row['question_type'])) {
            $row['question_type'] = $this->parseQuestionType($row['question_type']);
        }
        $row['the_correct_option_choice'] = $this->parseAnswers($row['the_correct_option_choice'] ?? '');
        return $row;
    }

    private function parseQuestionType(string $type): string|null
    {
        if (empty($type)) return null;
        $key = array_search($type, AssessmentQuestion::$TYPES, true);
        return $key !== false ? $key : null;
    }

    private function parseAnswers(string|int $correct_answer): array
    {
        if (is_string($correct_answer)) {
            return array_map('trim', explode(',', $correct_answer));
        } elseif (is_int($correct_answer)) {
            return [$correct_answer];
        }
        return [];
    }

    public function rules(): array
    {
        return [];
    }
}
