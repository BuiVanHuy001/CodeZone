<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\AssessmentTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Livewire\Component;

class Programming extends Component
{
    public int $moduleIndex;
    public int $lessonIndex;
    public array $newTestCase = ['input' => [], 'output' => []];
    public array $languages = [];
    public array $inputErrors = [];
    public string|null $outputError = null;
    public array $typeMap = [
        'int' => [
            'python' => 'int',
            'php' => 'int',
            'java' => 'int',
            'js' => 'number',
            'cpp' => 'int',
            'example' => '123',
            'regex' => '/^\d+$/'
        ],
        'float' => [
            'python' => 'float',
            'php' => 'float',
            'java' => 'float',
            'js' => 'number',
            'cpp' => 'float',
            'example' => '123.45',
            'regex' => '/^\d+(\.\d+)?$/'
        ],
        'string' => [
            'python' => 'str',
            'php' => 'string',
            'java' => 'String',
            'js' => 'string',
            'cpp' => 'string',
            'example' => '"Hello, World!"',
            'regex' => '/^".*"$/'
        ],
        'bool' => [
            'python' => 'bool',
            'php' => 'bool',
            'java' => 'boolean',
            'js' => 'boolean',
            'cpp' => 'bool',
            'example' => 'true',
            'regex' => '/^(true|false)$/'
        ],
        'array<int>' => [
            'python' => 'List[int]',
            'php' => 'array',
            'java' => 'int[]',
            'js' => 'number[]',
            'cpp' => 'vector<int>',
            'example' => '[1, 2, 3]',
            'regex' => '/^\[\d+(,\s*\d+)*\]$/'
        ],
        'array<float>' => [
            'python' => 'List[float]',
            'php' => 'array',
            'java' => 'float[]',
            'js' => 'number[]',
            'cpp' => 'vector<float>',
            'example' => '[1.1, 2.2, 3.3]',
            'regex' => '/^\[\d+(\.\d+)?(,\s*\d+(\.\d+)?)*\]$/'
        ],
        'array<string>' => [
            'python' => 'List[str]',
            'php' => 'array',
            'java' => 'String[]',
            'js' => 'string[]',
            'cpp' => 'vector<string>',
            'example' => '["apple", "banana", "cherry"]',
            'regex' => '/^\["[^"]*"(,\s*"[^"]*")*\]$/',],
        'array<bool>' => [
            'python' => 'List[bool]',
            'php' => 'array',
            'java' => 'boolean[]',
            'js' => 'boolean[]',
            'cpp' => 'vector<bool>',
            'example' => '[true, false, true]',
            'regex' => '/^\[(true|false)(,\s*(true|false))*\]$/'
        ]
    ];
    public $programmingPractice;
    public array $codeTemplates = [];
    public array $testCases = [];
    public array $problemDetails = [
        'functionName' => '',
        'returnType' => 'int',
        'params' => [],
    ];

    public function updatedLanguages(): void
    {
        if ($this->languages) {
            $this->makeCodeTemplate();
        }
        $this->dispatch('assignment-programming-updated',
            moduleIndex: $this->moduleIndex,
            lessonIndex: $this->lessonIndex,
            programmingPractice: $this->programmingPractice,
            problemDetails: $this->problemDetails,
            codeTemplate: json_encode($this->codeTemplates),


        );
    }

    private function makeCodeTemplate(): void
    {
        $functionName = $this->problemDetails['functionName'];
        $returnType = $this->problemDetails['returnType'];
        $params = $this->problemDetails['params'];

        foreach ($this->languages as $language) {
            $langParams = [];
            foreach ($params as $param) {
                $paramType = $this->typeMap[$param['type']][$language];
                $langParams[] = match ($language) {
                    'python' => "{$param['name']}: {$paramType}",
                    'php' => "{$paramType} \${$param['name']}",
                    'java' => "{$paramType} {$param['name']}",
                    'js' => $param['name'],
                    'cpp' => "{$paramType} {$param['name']}",
                    default => '',
                };
            }
            $paramString = implode(', ', $langParams);

            $template = match ($language) {
                'python' => $this->generatePythonTemplate($functionName, $returnType, $paramString),
                'php' => $this->generatePhpTemplate($functionName, $returnType, $paramString),
                'java' => $this->generateJavaTemplate($functionName, $returnType, $paramString),
                'js' => $this->generateJavaScriptTemplate($functionName, $returnType, $paramString, $params),
                'cpp' => $this->generateCppTemplate($functionName, $returnType, $paramString),
                default => '',
            };
            $this->codeTemplates[$language] = $template;
        }
    }

    private function generatePythonTemplate(string $functionName, string $returnType, string $paramString): string
    {
        return "class Solution:\n   def {$functionName}(self, {$paramString}) -> {$this->typeMap[$returnType]['python']}:\n        pass";
    }

    private function generatePhpTemplate(string $functionName, string $returnType, string $paramString): string
    {
        return "<?php\nclass Solution {\n    /**\n" . $this->generatePhpDoc($this->problemDetails['params'], $returnType) . "     */\n    function {$functionName}({$paramString}) {\n        // your code here\n    }\n}";
    }

    private function generatePhpDoc(array $params, string $returnType): string
    {
        $doc = '';
        foreach ($params as $param) {
            $doc .= "     * @param {$this->typeMap[$param['type']]['php']} \${$param['name']}\n";
        }
        $doc .= "     * @return {$this->typeMap[$returnType]['php']}\n";
        return $doc;
    }

    private function generateJavaTemplate(string $functionName, string $returnType, string $paramString): string
    {
        return "class Solution {\n    public {$returnType} {$functionName}({$paramString}) {\n        // your code here\n    }\n}";
    }

    private function generateJavaScriptTemplate(string $functionName, string $returnType, string $paramString, array $params): string
    {
        return "/**\n" . $this->generateJsDoc($params, $returnType) . " */\nvar {$functionName} = function({$paramString}) {\n    // your code here\n};";
    }

    private function generateJsDoc(array $params, string $returnType): string
    {
        $doc = '';
        foreach ($params as $param) {
            $doc .= " * @param {" . $param['type'] . "} " . $param['name'] . "\n";
        }
        $doc .= " * @return {" . $returnType . "}\n";
        return $doc;
    }

    private function generateCppTemplate(string $functionName, string $returnType, string $paramString): string
    {
        return "#include <vector>\n#include <string>\n\nclass Solution {\npublic:\n    {$returnType} {$functionName}({$paramString}) {\n        // your code here\n    }\n};";
    }

    public function updatedProblemDetailsFunctionName(): void
    {
        $functionName = trim($this->problemDetails['functionName']);

        if (preg_match('/^[0-9]/', $functionName)) {
            $this->dispatch('swal', [
                'icon' => 'warning',
                'title' => 'Invalid Input',
                'text' => 'Function name cannot start with a number. Leading numbers have been removed.',
            ]);
            $sanitizedName = preg_replace('/^[0-9]+/', '', $functionName);
        }
        $this->problemDetails['functionName'] = Str::camel($sanitizedName ?? $functionName);
    }

    public function addParameter(string $dataType, string $name): void
    {
        if ($this->isValidParameter($dataType, $name)) {
            $this->problemDetails['params'][] = [
                'name' => Str::camel(trim($name)),
                'type' => $dataType
            ];

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Parameter Added',
                'text' => 'The parameter has been successfully added.',
                'toast' => true,
                'position' => 'top-end',
                'showConfirmButton' => false,
                'timer' => 1000
            ]);
        }
    }

    private function isValidParameter(string $dataType, string $name): bool
    {
        if (empty($dataType) || empty($name) || !preg_match('/^[a-zA-Z][a-zA-Z0-9_ -]*$/', $name)) {
            $message = 'Data type and parameter name cannot be empty or contains special character.';
            $title = 'Invalid Parameter';
        }
        if (in_array($dataType, array_column($this->problemDetails['params'], 'type')) &&
            in_array(Str::camel(trim($name)), array_column($this->problemDetails['params'], 'name'))) {
            $message = 'This parameter already exists.';
            $title = 'Duplicate Parameter';
        }

        if (isset($message) && isset($title)) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => $title, 'text' => $message,]);
            return false;
        }

        return true;
    }

    public function removeParameter(int $index): void
    {
        if (isset($this->problemDetails['params'][$index])) {
            unset($this->problemDetails['params'][$index]);
            $this->problemDetails['params'] = array_values($this->problemDetails['params']);
            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Parameter Removed',
                'text' => 'The parameter has been successfully removed.',
                'toast' => true,
                'position' => 'top-end',
                'showConfirmButton' => false,
                'timer' => 1000
            ]);
        }
    }

    public function addTestCase(): void
    {
        if ($this->isValidTestCase()) {
            $inputData = [];
            foreach ($this->problemDetails['params'] as $param) {
                $paramName = $param['name'];
                $value = $this->newTestCase['input'][$paramName]['value'] ?? null;

                if (is_null($value)) {
                    return;
                }

                $inputData[$paramName] = ['type' => $param['type'], 'value' => $value,];
            }

            $outputValue = $this->newTestCase['output']['value'] ?? null;
            if (is_null($outputValue)) {
                return;
            }

            $this->testCases[] = [
                'input' => $inputData,
                'output' => [
                    'type' => $this->problemDetails['returnType'],
                    'value' => $outputValue
                ]
            ];

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Test Case Added',
                'text' => 'The test case has been successfully added.',
                'toast' => true,
                'position' => 'top-end',
                'showConfirmButton' => false,
                'timer' => 1000
            ]);
            $this->reset('newTestCase');
        }
    }

    private function isValidTestCase(): bool
    {
        $this->inputErrors = [];
        $this->outputError = null;
        if (empty($this->newTestCase['input']) || empty($this->newTestCase['output'])) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Invalid Test Case',
                'text' => 'Input and output cannot be empty.',
            ]);
            return false;
        }
        foreach ($this->newTestCase['input'] as $paramName => $value) {
            $expectedType = null;
            foreach ($this->problemDetails['params'] as $param) {
                if ($param['name'] === $paramName) {
                    $expectedType = $param['type'];
                    break;
                }
            }

            $regex = $this->typeMap[$expectedType]['regex'];

            if (!preg_match($regex, $value['value'])) {
                $this->inputErrors[$paramName] = "Invalid input for '{$paramName}'. Expected format example: " . $this->typeMap[$expectedType]['example'];
            }
        }

        if (isset($this->newTestCase['output']['value'])) {
            $expectedReturnType = $this->problemDetails['returnType'] ?? null;
            $regex = $this->typeMap[$expectedReturnType]['regex'] ?? null;

            if ($regex && !preg_match($regex, $this->newTestCase['output']['value'])) {
                $this->outputError = "Invalid output value. Expected format example: " . $this->typeMap[$expectedReturnType]['example'];
            }
        }
        if (!empty($this->inputErrors) || !is_null($this->outputError)) {
            $errorMessages = array_values($this->inputErrors);
            if ($this->outputError) {
                $errorMessages[] = $this->outputError;
            }

            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Invalid Test Case',
                'html' => '<div class="text-start">Please fix the following errors:<ul><li>' . implode('</li><li>', $errorMessages) . '</li></ul></div>',
                'showConfirmButton' => true,
            ]);
            return false;
        }

        return true;
    }

    public function removeTestCase(int $index): void
    {
        if (isset($this->testCases[$index])) {
            unset($this->testCases[$index]);
            $this->testCases = array_values($this->testCases);
            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Test Case Removed',
                'text' => 'The test case has been successfully removed.',
                'toast' => true,
                'position' => 'top-end',
                'showConfirmButton' => false,
                'timer' => 1000
            ]);
        }
    }

    public function saveProblemDetails(): void
    {
        $this->dispatch('programming-practice-saved',
            moduleIndex: $this->moduleIndex,
            lessonIndex: $this->lessonIndex,
            programmingPractice: $this->programmingPractice,
            problemDetails: $this->problemDetails,
            codeTemplates: json_encode($this->codeTemplates),
            testCases: json_encode($this->testCases),
            functionName: $this->problemDetails['functionName'],
        );
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.assessment-types.programming');
    }
}
