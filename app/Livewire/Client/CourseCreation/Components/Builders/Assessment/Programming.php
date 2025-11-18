<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Assessment;

use App\Services\Client\Course\Create\Builders\AssessmentTypes\ProgrammingService;
use App\Traits\WithSwal;
use App\Validator\ProgrammingPracticeValidator;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Programming extends Component {
    use WithSwal;

    #[Modelable]
    public array $programming;

    public bool $showDetails = true;

    public array $messages;

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
        return ProgrammingPracticeValidator::rules($this->newTestCase, self::$typeMap);
    }

    public function mount(): void
    {
        $this->messages = ProgrammingPracticeValidator::$MESSAGES;
    }

    /**
     * @throws Exception
     */
    public function updated($propertyName): void
    {
        try {
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
            $this->dispatch('assessment-updated', isValid: true);
        } catch (Exception $e) {
            $this->dispatch('assessment-updated', isValid: false);
            throw $e;
        }
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
        $problem = $this->problem ?? [];

        return filled($problem['function_name'] ?? null)
            && filled($problem['return_type'] ?? null)
            && !empty($problem['params'] ?? [])
            && !empty($problem['test_cases'] ?? []);
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
        $this->validate(ProgrammingPracticeValidator::getRulesNewParam(self::$typeMap));
        foreach ($this->problem['params'] as $param) {
            if (
                $param['type'] === $this->newParam['type'] &&
                strtolower($param['name']) === strtolower($this->newParam['name'])
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

        $this->swal(
            title: 'Parameter Added',
            text: 'The parameter has been added successfully.',
            toast: true,
            showConfirmButton: false,
            position: 'top-end',
            timer: 2000,
        );
    }

    public function removeParameter(string|int $index): void
    {
        unset($this->problem['params'][$index]);
        $this->problem['params'] = array_values($this->problem['params']);
        if (count($this->problem['test_cases']) !== 0) {
            $this->problem['test_cases'] = [];
        }

        $this->swal(
            title: 'Parameter Deleted',
            text: 'The parameter has been deleted successfully.',
            toast: true,
            showConfirmButton: false,
            position: 'top-end',
            timer: 2000,
        );
    }

    public function addTestCase(): void
    {
        $this->validate(ProgrammingPracticeValidator::getRulesNewTestCase(self::$typeMap, $this->newTestCase, $this->problem));;;

        $this->problem['test_cases'][] = $this->newTestCase;

        $this->resetNewTestCase();

        $this->swal(
            title: 'Test Case Added',
            text: 'The test case has been added successfully.',
            toast: true,
            showConfirmButton: false,
            position: 'top-end',
            timer: 2000,
        );
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
        $this->swal(
            title: 'Test Case Deleted',
            text: 'The test case has been deleted successfully.',
            toast: true,
            showConfirmButton: false,
            position: 'top-end',
            timer: 2000,
        );
    }

    /**
     * @throws Exception
     */
    public function saveProgramming(): void
    {
        try {
            $this->validate();
            $this->programming['problem_details']['function_name'] = $this->problem['function_name'];
            $this->programming['problem_details']['code_templates'] = json_encode($this->problem['code_templates'], JSON_THROW_ON_ERROR);
            $this->programming['problem_details']['test_cases'] = json_encode($this->problem['test_cases'], JSON_THROW_ON_ERROR);
            $this->showDetails = false;
            $this->dispatch('assessment-saved', id: $this->programming['title']);
            $this->dispatch('assessment-updated', isValid: true);
        } catch (Exception $e) {
            $this->swalError('Error', 'There was an error saving the programming assessment:', $e->getMessage());
            throw $e;
        }
    }

    public function remove(): void
    {
        if (isset($this->programming['title'])) {
            $this->dispatch('assessment-deleted', title: $this->programming['title']);
            $this->reset('programming', 'problem');
        }
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.assessment.programming', [
            'typeMap' => self::$typeMap,
        ]);
    }
}
