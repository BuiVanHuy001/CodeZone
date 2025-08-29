<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\AssessmentTypes;

use App\Services\CourseCreation\Builders\AssessmentTypes\ProgrammingService;
use App\Validator\ProgrammingPracticeValidator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Programming extends Component
{
    #[Modelable]
    public array $programming;

    public bool $showDetail = true;

    public array $messages;

    public string $allowedTypes;
    public static array $typeMap = [
        'int' => [
            'python' => 'int',
            'php' => 'int',
            'java' => 'int',
            'js' => 'number',
            'cpp' => 'int',
            'label' => 'Integer',
            'example' => '123',
            'regex' => '/^(0|-?[1-9]\d*)$/',
        ],
        'float' => [
            'python' => 'float',
            'php' => 'float',
            'java' => 'double',
            'js' => 'number',
            'cpp' => 'double',
            'label' => 'Float',
            'example' => '123.45',
            'regex' => '/^-?(?:\d+([.,]\d+)?|\d*[.,]\d+)$/',
        ],
        'string' => [
            'python' => 'str',
            'php' => 'string',
            'java' => 'String',
            'js' => 'string',
            'cpp' => 'string',
            'label' => 'String',
            'example' => '"Hello, World!"',
            'regex' => null,
        ],
        'bool' => [
            'python' => 'bool',
            'php' => 'bool',
            'java' => 'boolean',
            'js' => 'boolean',
            'cpp' => 'bool',
            'label' => 'Boolean',
            'example' => 'true',
            'regex' => '/^(true|false)$/i',
        ],
        'int[]' => [
            'python' => 'List[int]',
            'php' => 'array',
            'java' => 'int[]',
            'js' => 'number[]',
            'cpp' => 'vector<int>',
            'label' => 'Integer Array',
            'example' => '[1, -2, 3]',
            'regex' => '/^\[\s*((0|-?[1-9]\d*)(\s*,\s*(0|-?[1-9]\d*))*)?\s*\]$/',
        ],
        'float[]' => [
            'python' => 'List[float]',
            'php' => 'array',
            'java' => 'double[]',
            'js' => 'number[]',
            'cpp' => 'vector<double>',
            'label' => 'Float Array',
            'example' => '[1.1, 2, .5, -3.3]',
            'regex' => '/^\[\s*(-?(?:\d+([.,]\d+)?|\d*[.,]\d+)(\s*,\s*-?(?:\d+([.,]\d+)?|\d*[.,]\d+))*)?\s*\]$/',
        ],
        'string[]' => [
            'python' => 'List[str]',
            'php' => 'array',
            'java' => 'String[]',
            'js' => 'string[]',
            'cpp' => 'vector<string>',
            'label' => 'String Array',
            'example' => '["apple", "banana", "cherry"]',
            'regex' => '/^\[\s*("(?:[^"\\\\]|\\\\.)*"(?:\s*,\s*"(?:[^"\\\\]|\\\\.)*")*)?\s*\]$/',
        ],
        'bool[]' => [
            'python' => 'List[bool]',
            'php' => 'array',
            'java' => 'boolean[]',
            'js' => 'boolean[]',
            'cpp' => 'vector<bool>',
            'label' => 'Boolean Array',
            'example' => '[true, false, true]',
            'regex' => '/^\[\s*(true|false)(\s*,\s*(true|false))*\s*\]$/i',
        ],
    ];

    public array $newTestCase = [];

    public array $newParam = [
        'name' => '',
        'type' => ''
    ];

    public array $problem = [
        'function_name' => '',
        'return_type' => '',
        'params' => [],
        'test_cases' => [],
        'code_templates' => [],
        'allowed_languages' => [],
    ];

    public function rules(): array
    {
        return ProgrammingPracticeValidator::rules($this->allowedTypes, $this->newTestCase, self::$typeMap);
    }

    public function mount(): void
    {
        $this->messages = ProgrammingPracticeValidator::$MESSAGES;
        $this->allowedTypes = implode(',', array_keys(self::$typeMap));
    }

    public function updated($propertyName): void
    {
        if ($propertyName === 'problem.function_name') {
            $this->problem['function_name'] = $this->normalizeIdentifier($this->problem['function_name']);
        }

        if ($propertyName === 'newParam.name') {
            $this->newParam['name'] = $this->normalizeIdentifier($this->newParam['name']);
        }

        if ($propertyName === 'problem.return_type') {
            $this->newTestCase['output']['type'] = $this->problem['return_type'];
            if (count($this->problem['test_cases']) !== 0) {
                $this->problem['test_cases'] = [];
            }
        }

        $this->validateOnly($propertyName);
    }

    public function updatedProblemAllowedLanguages(ProgrammingService $programmingService): void
    {
        $this->validateOnly('problem.allowed_languages');
        $this->validateOnly('problem.function_name');
        $this->validateOnly('problem.return_type');
        $this->validateOnly('problem.params.*');

        $this->problem['code_templates'] = $programmingService->makeCodeTemplate(
            $this->problem['allowed_languages'],
            $this->problem
        );
    }

    public function getCanSelectLanguagesProperty(): bool
    {
        return $this->getErrorBag()->isEmpty()
            && !empty($this->problem['function_name'])
            && !empty($this->problem['return_type'])
            && !empty($this->problem['params']);
    }

    private function normalizeIdentifier(?string $functionName): ?string
    {
        if (preg_match('/[^a-zA-Z0-9\s]/u', $functionName) || preg_match('/^\d/', $functionName)) {
            return $functionName;
        }

        return Str::camel($functionName);
    }

    public function validateStep1(): bool
    {
        $this->validateOnly('programming.title');
        $this->validateOnly('programming.description');
        return true;
    }

    public function addParameter(): void
    {
        $this->validateOnly('newParam.name');
        $this->validateOnly('newParam.type');

        foreach ($this->problem['params'] as $param) {
            if (
                strtolower($param['name']) === strtolower($this->newParam['name']) &&
                $param['type'] === $this->newParam['type']
            ) {
                $this->addError('newParam.name', 'This parameter name and type already exists.');
                return;
            }
        }

        $this->problem['params'][] = $this->newParam;

        $this->newTestCase['inputs'][] = [
            'name' => $this->newParam['name'],
            'type' => $this->newParam['type'],
            'value' => ''
        ];

        if (count($this->problem['test_cases']) !== 0) {
            $this->problem['test_cases'] = [];
        }

        $this->newParam = [
            'name' => '',
            'type' => ''
        ];

        $this->dispatch('swal', [
            'title' => 'Parameter Added',
            'text' => 'The parameter has been added successfully.',
            'icon' => 'success',
            'toast' => true,
            'timer' => 2000,
            'showConfirmButton' => false,
            'position' => 'top-end',
        ]);
    }

    public function removeParameter(string|int $index): void
    {
        unset($this->problem['params'][$index]);
        $this->problem['params'] = array_values($this->problem['params']);
        if (count($this->problem['test_cases']) !== 0) {
            $this->problem['test_cases'] = [];
        }
        $this->dispatch('swal', [
            'title' => 'Parameter Deleted',
            'text' => 'The parameter has been deleted successfully.',
            'icon' => 'success',
            'toast' => true,
            'timer' => 3000,
            'showConfirmButton' => false,
            'position' => 'top-end',
        ]);
    }

    public function addTestCase(): void
    {
        $this->validateOnly('newTestCase.inputs.*.value');
        $this->validateOnly('problem.return_type');
        $this->validateOnly('newTestCase.output.value');
        $this->validateOnly('newTestCase.inputs.*.type');
        $this->validateOnly('newTestCase.output.type');

        $this->problem['test_cases'][] = $this->newTestCase;

        $this->resetNewTestCase();

        $this->dispatch('swal', [
            'title' => 'Test Case Added',
            'text' => 'The test case has been added successfully.',
            'icon' => 'success',
            'toast' => true,
            'timer' => 2000,
            'showConfirmButton' => false,
            'position' => 'top-end',
        ]);
    }

    private function resetNewTestCase(): void
    {
        $inputs = [];
        foreach ($this->problem['params'] as $param) {
            $inputs[] = [
                'name' => $param['name'],
                'type' => $param['type'],
                'value' => ''
            ];
        }

        $this->newTestCase['inputs'] = $inputs;

        if (isset($this->problem['return_type'])) {
            $this->newTestCase['output']['type'] = $this->problem['return_type'];
            $this->newTestCase['output']['value'] = '';
        }
    }

    public function removeTestCase(string|int $index): void
    {
        unset($this->problem['test_cases'][$index]);
        $this->dispatch('swal', [
            'title' => 'Test Case Deleted',
            'text' => 'The test case has been deleted successfully.',
            'icon' => 'success',
            'toast' => true,
            'timer' => 3000,
            'showConfirmButton' => false,
            'position' => 'top-end',
        ]);
    }

    public function save(): void
    {
        $this->programming['problem_details'] = $this->problem;
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.assessment-types.programming', [
            'typeMap' => self::$typeMap,
        ]);
    }
}
