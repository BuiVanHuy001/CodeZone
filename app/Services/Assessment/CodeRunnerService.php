<?php

namespace App\Services\Assessment;

use App\Models\Assessment;
use App\Models\AssessmentAttempt;
use App\Models\AttemptProgramming;
use App\Models\ProgrammingProblems;

class CodeRunnerService
{
    public function run(string $language, string $userCode, ProgrammingProblems $problem): array
    {
        $errors = [];
        $isPassed = true;
        $testCases = json_decode($problem['test_cases'], true, 512, JSON_THROW_ON_ERROR);

        foreach ($testCases as $testCase) {
            $expected_output = $testCase['output']['value'];

            $fullCode = $this->generateFullCodeExecution(
                $language,
                $problem['function_name'],
                $testCase['inputs'],
                $userCode
            );

            $actual_output = $this->executeCode($fullCode, $language);

            $result_status = (trim($actual_output) === trim($expected_output)) ? 'pass' : 'failed';

            if ($result_status === 'failed') {
                $isPassed = false;
                $errors = $this->generateErrorOutput($actual_output);
                break;
            }
        }

        return [
            'isPassed' => $isPassed,
            'errors' => $errors,
        ];
    }

    public function saveProgrammingAttempt(string|int $total_score, Assessment $assessment, bool $is_passed, string $user_code, string $language): void
    {
        $assessmentAttempt = AssessmentAttempt::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'assessment_id' => $assessment->id,
            ],
            [
                'total_score' => $total_score,
                'is_passed' => $is_passed,
            ]
        );

        $existing = AttemptProgramming::where('assessment_attempt_id', $assessmentAttempt->id)
            ->where('language', $language)
            ->first();

        if ($existing) {
            $existing->update([
                'user_code' => $user_code,
                'language' => $language,
            ]);
        } else {
            AttemptProgramming::create([
                'assessment_attempt_id' => $assessmentAttempt->id,
                'user_code' => $user_code,
                'language' => $language,
            ]);
        }
    }

    private function generateFullCodeExecution(string $language, string $functionName, array $testCaseInputs, string $userCode): string
    {
        $inputVariables = implode(', ', array_map(fn($input) => $input['name'], $testCaseInputs));
        $testCaseInput = $this->generateInputCode($testCaseInputs, $language);
        $callerCode = $this->generateCallerCode($language, $functionName, $inputVariables);

        if ($language === 'php') {
            $userCode = preg_replace('/^\s*<\?php\s*/', '', $userCode);
            return '<?php\n' . $testCaseInput . "\n" . $userCode . "\n" . $callerCode;
        }
        return $testCaseInput . "\n" . $userCode . "\n" . $callerCode;
    }

    private function generateCallerCode(string $language, string $functionName, string $inputVariables): string
    {
        $entrypoint = [
            'className' => 'Solution',
            'methodName' => $functionName
        ];
        $callerCode = '';

        switch ($language) {
            case 'python':
                $callerCode = "solution = {$entrypoint['className']}()\n";
                $callerCode .= "result = solution.{$entrypoint['methodName']}($inputVariables)\n";
                $callerCode .= "import json\n";
                $callerCode .= "print(json.dumps(result))\n";
                break;

            case 'js':
                $callerCode = "const solution = new {$entrypoint['className']}();\n";
                $callerCode .= "const result = solution.{$entrypoint['methodName']}($inputVariables);\n";
                $callerCode .= "console.log(JSON.stringify(result));\n";
                break;

            case 'php':
                $callerCode = "\$solution = new {$entrypoint['className']}();\n";
                $callerCode .= "\$result = \$solution->{$entrypoint['methodName']}($inputVariables);\n";
                $callerCode .= "echo json_encode(\$result);\n";
                break;
        }
        return $callerCode;
    }

    private function generateInputCode(array $inputs, string $language): string
    {
        $inputCode = '';
        foreach ($inputs as $input) {
            $name = $input['name'];
            $value = $input['value'];

            switch ($language) {
                case 'php':
                    $phpValue = eval('return ' . $value . ';');
                    $inputCode .= '$' . $name . ' = ' . var_export($phpValue, true) . ";\n";
                    break;

                case 'python':
                    $inputCode .= $name . ' = ' . $value . "\n";
                    break;

                case 'js':
                    $inputCode .= 'const ' . $name . ' = ' . $value . ";\n";
                    break;

                case 'java':
                    break;
            }
        }
        return $inputCode;
    }

    private function generateErrorOutput(string $output): string
    {
        $lines = preg_split('/\r\n|\r|\n/', $output);
        $clean = [];

        foreach ($lines as $line) {
            if (preg_match('#^(/private)?/var/folders/.*/user_script_.*\.(?:js|py|php):\d+#', $line)) {
                continue;
            }

            $line = preg_replace(
                '#\((?:/private)?/var/folders/[^)]+user_script_[^):]+\.(?:js|py|php):\d+(?::\d+)?\)#',
                '([user_script])',
                $line
            );
            $line = preg_replace(
                '#(?:/private)?/var/folders/[^ \t\n\r)]+user_script_[^ \t\n\r):]+\.(?:js|py|php):\d+(?::\d+)?#',
                '[user_script]',
                $line
            );
            $line = preg_replace(
                '#/tmp/user_script_[^ \t\n\r):]+\.(?:js|py|php):\d+(?::\d+)?#',
                '[user_script]',
                $line
            );

            if (preg_match('#^\s+at node:internal#', $line)) {
                continue;
            }

            $clean[] = $line;
        }

        return trim(implode("\n", array_filter($clean, fn($l) => $l !== '')));
    }

    private function executeCode(string $code, string $language): string
    {
        $languageMap = $this->mapLanguage($language);
        $tmp_file = sys_get_temp_dir() . '/user_script_' . uniqid() . $languageMap['extension'];
        file_put_contents($tmp_file, $code);
        $output = shell_exec($languageMap['command'] . escapeshellarg($tmp_file) . ' 2>&1');
        unlink($tmp_file);
        return $output;
    }

    private function mapLanguage(string $language): array
    {
        $languageMap = [
            'python' => [
                'extension' => '.py',
                'command' => 'python3 '
            ],
            'js' => [
                'extension' => '.js',
                'command' => 'node '
            ],
            'php' => [
                'extension' => '.php',
                'command' => 'php '
            ],
        ];
        return $languageMap[$language];
    }
}
