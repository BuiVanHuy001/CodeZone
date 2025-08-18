<?php

namespace App\Imports;

use AllowDynamicProperties;
use App\Models\AssessmentQuestion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuizzesImport implements ToCollection, WithHeadingRow, SkipsOnFailure, WithValidation
{
    use SkipsErrors, SkipsFailures;

    private array $quizzes = [];

    public function collection(Collection $collection): void
    {
        $this->quizzes = $collection->map(function ($row) {
            return [
                'question' => $row['text_of_the_question'],
                'answers' => $row['answer'],
                'correct_answer' => $row['correct_answer'],
            ];
        })->toArray();
    }

    public function getQuizzes(): array
    {
        return $this->quizzes;
    }

    public function rules(): array
    {
        return [
            //            '*.question' => 'required',
            //            '*.answer' => 'required',
            //            '*.correct_answer' => 'required',
        ];
    }
}
