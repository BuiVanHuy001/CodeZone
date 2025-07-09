<?php

namespace App\Imports;

use AllowDynamicProperties;
use App\Models\AssessmentQuestion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuizzesImport implements ToCollection
{
    public function collection(Collection $collection): void
    {
        $this->parsed = $collection->slice(1)->map(function ($row) {
	        $type = $row[1] ?? '';
	        if (array_key_exists($type, AssessmentQuestion::$QUIZ_TYPES)) {
		        $type = AssessmentQuestion::$QUIZ_TYPES[$type];
	        }
	        $question = ['content' => $row[0] ?? '', 'type' => $type ?? '', 'question_options' => [],];

            $correctOptionsRaw = trim($row[10] ?? '');
	        $correctIndexes = collect(explode(',', $correctOptionsRaw))->map(fn($val) => (int)trim($val))->filter(fn($val) => $val >= 1 && $val <= 4)->values()->toArray();

            for ($i = 0; $i < 4; $i++) {
                $content = $row[2 + ($i * 2)] ?? null;
                $explanation = $row[3 + ($i * 2)] ?? null;
                if (!$content) continue;
	            $question['question_options'][] = ['content' => $content, 'is_correct' => in_array($i + 1, $correctIndexes), 'position' => $i + 1, 'explanation' => $explanation ?? '',];
            }

            return $question;
        })->filter(fn($q) => !empty($q['content']));
    }

    public function getParsed(): array
    {
        return $this->parsed->toArray();
    }

}
