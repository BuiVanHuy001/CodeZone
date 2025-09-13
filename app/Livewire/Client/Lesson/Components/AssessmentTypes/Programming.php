<?php
namespace App\Livewire\Client\Lesson\Components\AssessmentTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Programming extends Component
{
    public $programmingPractice;
    public $codeTemplates = [];
    public $allowedLanguages = [];
    public string $languageSelected;
    public string $userCode;
    public array $submissionResults = [];
    public string $template;

    public function mount(): void
    {
        $decodedTemplates = json_decode($this->programmingPractice->problemDetails['code_templates'], true);
        $this->codeTemplates = $decodedTemplates;
        $this->allowedLanguages = array_keys($decodedTemplates);
        $this->languageSelected = $this->allowedLanguages[0];
        $this->template = $this->codeTemplates[$this->languageSelected];
    }

    public function updatedLanguageSelected(): void
    {
        $this->template = $this->codeTemplates[$this->languageSelected];
        $this->dispatch('language-changed', templateCode: $this->template);
    }

    public function submitCode(): void
    {
        $this->submissionResults = [];
        $testCases = json_decode($this->programmingPractice->problemDetails['test_cases'], true);

        $entrypoint = [
            'className' => 'Solution',
            'methodName' => $this->programmingPractice->problemDetails['function_name']
        ];

        foreach ($testCases as $index => $testCase) {
            $testCaseInput = $this->generateInputCode($testCase['input'], $this->languageSelected);
            $inputVariables = implode(', ', array_keys($testCase['input']));
            $callerCode = '';

            switch ($this->languageSelected) {
                //                case 'php':
                //                    $inputVariables = '$' . implode(', $', array_keys($testCase['input']));
                //                    $callerCode = "\$solution = new {$entrypoint['className']}();\n";
                //                    $callerCode .= "\$result = \$solution->{$entrypoint['methodName']}($inputVariables);\n";
                //                    $callerCode .= "echo json_encode(\$result);\n";
                //                    break;
                case 'python':
                    $callerCode = "solution = {$entrypoint['className']}()\n";
                    $callerCode .= "result = solution.{$entrypoint['methodName']}($inputVariables)\n";
                    $callerCode .= "import json\n";
                    $callerCode .= "print(json.dumps(result))\n";
                    break;
                //                case 'js':
                //                    $callerCode = "const solution = new {$entrypoint['className']}();\n";
                //                    $callerCode .= "const result = solution.{$entrypoint['methodName']}($inputVariables);\n";
                //                    $callerCode .= "console.log(JSON.stringify(result));\n";
                //                    break;
            }

            $fullCode = $testCaseInput . "\n" . $this->userCode . "\n" . $callerCode;
            $expected_output = $testCase['output']['value'];
            $actual_output = '';
            try {
                switch ($this->languageSelected) {
                    //                    case 'php':
                    //                        ob_start();
                    /*                        eval('?>' . $fullCode);*/
                    //                        $actual_output = ob_get_clean();
                    //                        break;
                    case 'python':
                        $tmp_file = sys_get_temp_dir() . '/user_script_' . uniqid() . '.py';
                        file_put_contents($tmp_file, $fullCode);
                        $actual_output = shell_exec('python3 ' . escapeshellarg($tmp_file) . ' 2>&1');
                        unlink($tmp_file);
                        break;
                    //                    case 'js':
                    //                        $extension = $this->languageSelected === 'python' ? 'py' : 'js';
                    //                        $command = $this->languageSelected === 'python' ? 'python3' : 'node';
                    //                        $tmp_file = sys_get_temp_dir() . '/user_script_' . uniqid() . '.' . $extension;
                    //                        file_put_contents($tmp_file, $fullCode);
                    //                        $actual_output = shell_exec($command . ' ' . escapeshellarg($tmp_file) . ' 2>&1');
                    //                        unlink($tmp_file);
                    //                        break;
                }

                $normalized_actual = json_encode(json_decode(trim($actual_output)));
                $normalized_expected = json_encode(json_decode(trim($expected_output)));

                if ($normalized_actual === $normalized_expected) {
                    $result_status = 'pass';
                } else {
                    $result_status = 'failed';
                }

            } catch (\Throwable $e) {
                $actual_output = $e->getMessage();
                $result_status = 'error';
            }

            $this->submissionResults[] = [
                'case' => $index + 1,
                'status' => $result_status,
                'expected' => $expected_output,
                'actual' => trim($actual_output),
            ];
        }

        $isPass = true;
        foreach ($this->submissionResults as $result) {
            if ($result['status'] !== 'pass') {
                $isPass = false;
                break;
            }
        }
        if ($isPass) {
            $this->dispatch('swal',
                [
                    'title' => __('Assessment Submitted'),
                    'text' => __('Your code has been passed all test case.'),
                    'icon' => 'success',
                ]
            );
        } else {
            $this->dispatch('swal',
                [
                    'title' => __('Assessment Failed'),
                    'text' => __('Please review your code and try again.'),
                    'icon' => 'error',
                ]
            );
        }
    }

    private function generateInputCode(array $inputs, string $language): string
    {
        $inputCode = '';
        foreach ($inputs as $name => $details) {
            $value = $details['value'];
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
            }
        }
        return $inputCode;
    }


    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.assessment-types.programming');
    }
}
