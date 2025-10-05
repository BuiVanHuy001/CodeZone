<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\ProgrammingProblems;
use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;
use JsonException;
use Random\RandomException;

class AssessmentSeeder extends Seeder
{
    private array $programmingProblems = [
        [
            'function_name' => 'twoSum',
            'code_templates' => '{"js": "class Solution {\n    /**\n     * @param {number} target\n     * @param {number[]} nums\n     * @return {number[]}\n     */\n    twoSum(target, nums) {\n        // TODO: implement your solution here\n        return [];\n    }\n}", "php": "<?php\nclass Solution {\n    public function twoSum(int $target, array $nums): array {\n        // TODO: implement your solution here\n        return [];\n    }\n}", "java": "class Solution {\n    public int[] twoSum(int target, int[] nums) {\n        // TODO: implement your solution here\n        return null;\n    }\n}", "python": "from typing import List\n\nclass Solution:\n    def twoSum(self, target: int, nums: List[int]) -> List[int]:\n        # TODO: implement your solution here\n        pass\n"}',
            'test_cases' => '[{"inputs": [{"name": "target", "type": "int", "value": "9"}, {"name": "nums", "type": "int[]", "value": "[2, 7, 11, 15]"}], "output": {"type": "int[]", "value": "[0, 1]"}}, {"inputs": [{"name": "target", "type": "int", "value": "0"}, {"name": "nums", "type": "int[]", "value": "[-3, 4, 3, 90]"}], "output": {"type": "int[]", "value": "[0, 2]"}}, {"inputs": [{"name": "target", "type": "int", "value": "6"}, {"name": "nums", "type": "int[]", "value": "[3, 2, 4]"}], "output": {"type": "int[]", "value": "[1, 2]"}}, {"inputs": [{"name": "target", "type": "int", "value": "11"}, {"name": "nums", "type": "int[]", "value": "[1, 2, 3, 4, 5, 6]"}], "output": {"type": "int[]", "value": "[4, 5]"}}]'
        ],
        [
            'function_name' => 'hasPairWithDiff',
            'code_templates' => '{"js": "class Solution {\n    /**\n     * @param {number[]} nums\n     * @param {number} k\n     * @return {boolean}\n     */\n    hasPairWithDiff(nums, k) {\n        // TODO: implement your solution here\n        return false;\n    }\n}", "php": "<?php\nclass Solution {\n    public function hasPairWithDiff(array $nums, int $k): bool {\n        // TODO: implement your solution here\n        return false;\n    }\n}", "java": "class Solution {\n    public boolean hasPairWithDiff(int[] nums, int k) {\n        // TODO: implement your solution here\n        return null;\n    }\n}", "python": "from typing import List\n\nclass Solution:\n    def hasPairWithDiff(self, nums: List[int], k: int) -> bool:\n        # TODO: implement your solution here\n        pass\n"}',
            'test_cases' => '[{"inputs": [{"name": "nums", "type": "int[]", "value": "[5, 20, 3, 2, 50, 80]"}, {"name": "k", "type": "int", "value": "78"}], "output": {"type": "bool", "value": "true"}}, {"inputs": [{"name": "nums", "type": "int[]", "value": "[90, -10, 20, 80]"}, {"name": "k", "type": "int", "value": "-100"}], "output": {"type": "bool", "value": "true"}}, {"inputs": [{"name": "nums", "type": "int[]", "value": "[1, 2, 3, 4]"}, {"name": "k", "type": "int", "value": "10"}], "output": {"type": "bool", "value": "false"}}, {"inputs": [{"name": "nums", "type": "int[]", "value": "[10, 20, 30]"}, {"name": "k", "type": "int", "value": "0"}], "output": {"type": "bool", "value": "false"}}]'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(string $lessonId): void
    {
        $type = fake()->randomElement(array_keys(Assessment::$ASSESSMENT_PRACTICE_TYPES));
        $assessment = Assessment::create([
            'lesson_id' => $lessonId,
            'title' => fake()->words(4, true),
            'description' => fake()->paragraphs(5, true),
            'type' => $type,
        ]);
        if ($type === 'quiz') {
            $questionCount = fake()->numberBetween(5, 20);
            $assessment->update([
                'question_count' => $questionCount,
            ]);
            $this->generateQuiz($questionCount, $assessment->id);
        } else {
            $this->generateProgramming($assessment->id);
        }
    }

    /**
     * @throws RandomException|JsonException
     */
    private function generateQuiz(int $questionCount, string|int $assessmentId): void
    {
        for ($i = 0; $i < $questionCount; $i++) {
            QuizQuestion::create([
                'content' => fake()->words(random_int(3, 9), true) . '?',
                'type' => fake()->randomElement(array_keys(QuizQuestion::$TYPES)),
                'options' => $this->generateOptions(),
                'position' => $i + 1,
                'assessment_id' => $assessmentId,
            ]);
        }
    }

    /**
     * @throws RandomException|JsonException
     */
    private function generateOptions(): string
    {
        $optionCount = random_int(2, 5);
        $options = [];

        $correctAnswersCount = random_int(1, min(2, $optionCount));

        for ($i = 0; $i < $optionCount; $i++) {
            $options[] = [
                'content' => fake()->sentence(random_int(4, 10)),
                'is_correct' => $i < $correctAnswersCount,
                'explanation' => fake()->sentence(random_int(6, 15)),
            ];
        }
        shuffle($options);

        return json_encode($options, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

    private function generateProgramming(string|int $assessmentId): void
    {
        $problem = fake()->randomElement($this->programmingProblems);
        ProgrammingProblems::create([
            'function_name' => $problem['function_name'],
            'code_templates' => $problem['code_templates'],
            'test_cases' => $problem['test_cases'],
            'assessment_id' => $assessmentId,
        ]);
    }
}
