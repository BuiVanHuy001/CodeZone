<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
    ];

    public static array $TYPES = [
        'multiple_choice' => 'Multiple Choice',
    ];

    public static array $EXPECTED_COLUMNS = [
        'text_of_the_question' => ' Text of the question',
        'question_type' => ' Question type',
        'option_1' => ' Option 1',
        'explanation_option_1' => ' Explanation option 1',
        'option_2' => ' Option 2',
        'explanation_option_2' => ' Explanation option 2',
        'option_3' => ' Option 3',
        'explanation_option_3' => ' Explanation option 3',
        'option_4' => ' Option 4',
        'explanation_option_4' => ' Explanation option 4',
        'the_correct_option_choice' => 'The correct option choice',
    ];

    public static array $REQUIRED_COLUMNS = [
        'text_of_the_question',
        'the_correct_option_choice',
        'option_1',
        'option_2',
    ];

    public function isMultipleAnswers(): bool
    {
        $answerCount = 0;
        $decodeOptions = json_decode($this->options, true, 512, JSON_THROW_ON_ERROR);

        foreach ($decodeOptions as $option) {
            if ($option['is_correct']) {
                $answerCount++;
            }
        }
        return $answerCount > 1;
    }
}
