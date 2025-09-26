<?php

namespace App\Validator;

use App\Models\ProgrammingProblems;

class ProgrammingPracticeValidator {
    public static array $MESSAGES = [
        'programming.title.required' => 'Title is required.',
        'programming.title.min' => 'Title must be at least :min characters.',
        'programming.title.max' => 'Title cannot exceed :max characters.',
        'programming.description.required' => 'Description is required.',

        'problem.function_name.required' => 'Function name is required.',
        'problem.function_name.regex' => 'Function name must be camelCase (letters/numbers only).',
        'problem.function_name.min' => 'Function name must be at least :min characters.',
        'problem.function_name.max' => 'Function name cannot exceed :max characters.',
        'problem.return_type.required' => 'Return type is required.',
        'problem.return_type.in' => 'Invalid return type.',
        'problem.allowed_languages.required' => 'At least one language is required.',
        'problem.allowed_languages.in' => 'Invalid language.',
        'problem.allowed_languages.min' => 'At least one language is required.',

        'problem.params.*.name.required' => 'Parameter name is required.',
        'problem.params.*.name.min' => 'Parameter name must be at least :min characters.',
        'problem.params.*.name.max' => 'Parameter name cannot exceed :max characters.',
        'problem.params.*.type.required' => 'Parameter type is required.',
        'problem.params.*.type.in' => 'Invalid parameter type.',

        'problem.test_cases.*.inputs.*.value.required' => 'Input value is required.',
        'problem.test_cases.*.output.value.required' => 'Expected output is required.',
        'problem.test_cases.*.inputs.*.type.required' => 'Input type is required.',
        'problem.test_cases.*.inputs.*.type.in' => 'Invalid input type.',
        'problem.test_cases.*.output.type.required' => 'Output type is required.',
        'problem.test_cases.*.output.type.in' => 'Invalid output type.',

        'problem.code-template.required' => 'Code template is required.',
        'problem.code-template.min' => 'Code template cannot be empty.',

        'newParam.name.required' => 'Parameter name is required.',
        'newParam.name.max' => 'Parameter name cannot exceed :max characters.',
        'newParam.type.required' => 'Parameter type is required.',
        'newParam.type.in' => 'Invalid parameter type.',

        'newTestCase.inputs.*.value.required' => 'Input value is required.',
        'newTestCase.inputs.*.type.required' => 'Input type is required.',
        'newTestCase.inputs.*.type.in' => 'Invalid input type.',
        'newTestCase.output.value.required' => 'Expected output is required.',
        'newTestCase.output.type.required' => 'Output type is required.',
        'newTestCase.output.type.in' => 'Invalid output type.',
    ];

    public static function rules($newTestCase, array $typeMap): array
    {
        $allowedTypes = implode(',', array_keys($typeMap));
        return [
            'programming.title' => 'required|min:3|max:50',
            'programming.description' => 'required',
            'problem.function_name' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    self::validateIdentifier('function name', $value, $fail);
                },
            ],
            'problem.return_type' => 'required|in:' . $allowedTypes,
            'problem.allowed_languages' => 'required|array|min:1|in:' . implode(',', array_keys(ProgrammingProblems::$SUPPORTED_LANGUAGES)),

            'problem.params' => [
                function ($attribute, $value, $fail) {
                    if (empty($value) || count(array_filter($value, fn($p) => !empty($p['name']) && !empty($p['type']))) === 0) {
                        $fail('At least one parameter is required.');
                    }
                }
            ],

            'problem.params.*.name' => 'required_with:problem.params.*.type|min:1|max:20',
            'problem.params.*.type' => 'required_with:problem.params.*.name|in:' . $allowedTypes,

            'problem.test_cases.*.inputs.*.value' => 'required',
            'problem.test_cases.*.output.value' => 'required',
            'problem.test_cases.*.inputs.*.type' => 'required|in:' . $allowedTypes,
            'problem.test_cases.*.output.type' => 'required|in:' . $allowedTypes,
        ];
    }

    public static function validateValueByType(string $type, string $value, \Closure $fail, array $typeMap = []): void
    {
        $regex = $typeMap[$type]['regex'] ?? null;
        if ($regex && !preg_match($regex, $value)) {
            $fail("Invalid format for {$type}. Expected: {$typeMap[$type]['example']}");
        }
    }

    public static function validateIdentifier(string $attribute, string $value, \Closure $fail): void
    {
        if (!preg_match('/^[a-z][a-zA-Z0-9_]*$/', $value)) {
            $fail("The {$attribute} must start with a lowercase letter and contain only letters, numbers, or underscores.");
            return;
        }
        $reserved = ['class', 'function', 'var', 'let', 'const', 'if', 'else', 'elseif', 'endif', 'switch', 'case', 'default', 'break', 'continue', 'return', 'for', 'foreach', 'while', 'do', 'endwhile', 'try', 'catch', 'finally', 'throw', 'new', 'public', 'private', 'protected', 'static', 'abstract', 'interface', 'extends', 'implements', 'trait', 'namespace', 'use', 'global', 'unset', 'true', 'false', 'null', 'void', 'int', 'float', 'string', 'bool', 'array', 'object', 'import', 'package', 'this', 'super', 'def', 'lambda', 'yield', 'await', 'async'];
        if (in_array(strtolower($value), $reserved, true)) {
            $fail("The {$attribute} cannot be a reserved keyword.");
        }
    }

    public static function getRulesNewParam(array $typeMap): array
    {
        return [
            'newParam.name' => [
                'required',
                'min:1',
                'max:20',
                function ($attribute, $value, $fail) {
                    ProgrammingPracticeValidator::validateIdentifier('parameter name', $value, $fail);
                },
            ],
            'newParam.type' => 'required|in:' . implode(',', array_keys($typeMap)),
        ];
    }

    public static function getRulesNewTestCase(array $typeMap, array $newTestCase, array $problem): array
    {
        $allowedTypes = implode(',', array_keys($typeMap));

        return [
            'newTestCase.inputs.*.name' => [
                'required',
                'min:1',
                'max:20',
                function ($attribute, $value, $fail) {
                    ProgrammingPracticeValidator::validateIdentifier('input name', (string)$value, $fail);
                },
            ],
            'newTestCase.inputs.*.type' => [
                'required',
                'in:' . $allowedTypes,
                function ($attribute, $value, $fail) use ($problem) {
                    $segments = explode('.', $attribute);
                    $index = (int)($segments[2] ?? -1);

                    $expectedType = data_get($problem, "params.$index.type");
                    if ($expectedType && $value !== $expectedType) {
                        $fail("Input type must match the parameter type '{$expectedType}'.");
                    }
                },
            ],
            'newTestCase.inputs.*.value' => [
                'required',
                function ($attribute, $value, $fail) use ($newTestCase, $typeMap) {
                    $segments = explode('.', $attribute); // newTestCase, inputs, {index}, value
                    $index = (int)($segments[2] ?? -1);

                    $type = data_get($newTestCase, "inputs.$index.type");
                    if ($type) {
                        ProgrammingPracticeValidator::validateValueByType($type, (string)$value, $fail, $typeMap);
                    }
                },
            ],
            'newTestCase.output.type' => [
                'required',
                'in:' . $allowedTypes,
                function ($attribute, $value, $fail) {
                    $returnType = $problem['return_type'] ?? null;
                    if ($returnType && $value !== $returnType) {
                        $fail("Output type must match the return type '{$returnType}'.");
                    }
                },
            ],
            'newTestCase.output.value' => [
                'required',
                function ($attribute, $value, $fail) use ($newTestCase, $typeMap) {
                    $type = data_get($newTestCase, 'output.type') ?: ($problem['return_type'] ?? null);
                    if ($type) {
                        ProgrammingPracticeValidator::validateValueByType($type, (string)$value, $fail, $typeMap);
                    }
                },
            ],
        ];
    }
}
