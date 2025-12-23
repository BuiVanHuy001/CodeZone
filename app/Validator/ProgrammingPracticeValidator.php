<?php

namespace App\Validator;

use App\Models\ProgrammingProblems;

class ProgrammingPracticeValidator {
    public static array $MESSAGES = [
        'programming.title.required' => 'Tiêu đề bài thực hành không được để trống.',
        'programming.title.min' => 'Tiêu đề phải có ít nhất :min ký tự.',
        'programming.title.max' => 'Tiêu đề không được vượt quá :max ký tự.',
        'programming.description.required' => 'Vui lòng nhập mô tả bài thực hành.',

        'problem.function_name.required' => 'Tên hàm là bắt buộc.',
        'problem.function_name.regex' => 'Tên hàm phải tuân theo định dạng camelCase (chỉ bao gồm chữ cái và số).',
        'problem.function_name.min' => 'Tên hàm phải có ít nhất :min ký tự.',
        'problem.function_name.max' => 'Tên hàm không được vượt quá :max ký tự.',
        'problem.return_type.required' => 'Vui lòng chọn kiểu dữ liệu trả về.',
        'problem.return_type.in' => 'Kiểu dữ liệu trả về không hợp lệ.',
        'problem.allowed_languages.required' => 'Vui lòng chọn ít nhất một ngôn ngữ lập trình.',
        'problem.allowed_languages.in' => 'Ngôn ngữ lập trình không hợp lệ.',
        'problem.allowed_languages.min' => 'Phải có ít nhất một ngôn ngữ được cho phép.',

        'problem.params.*.name.required' => 'Tên tham số không được để trống.',
        'problem.params.*.name.min' => 'Tên tham số phải có ít nhất :min ký tự.',
        'problem.params.*.name.max' => 'Tên tham số không được vượt quá :max ký tự.',
        'problem.params.*.type.required' => 'Vui lòng chọn kiểu dữ liệu cho tham số.',
        'problem.params.*.type.in' => 'Kiểu dữ liệu tham số không hợp lệ.',

        'problem.test_cases.*.inputs.*.value.required' => 'Giá trị đầu vào không được để trống.',
        'problem.test_cases.*.output.value.required' => 'Kết quả đầu ra mong đợi là bắt buộc.',
        'problem.test_cases.*.inputs.*.type.required' => 'Kiểu dữ liệu đầu vào là bắt buộc.',
        'problem.test_cases.*.inputs.*.type.in' => 'Kiểu dữ liệu đầu vào không hợp lệ.',
        'problem.test_cases.*.output.type.required' => 'Kiểu dữ liệu đầu ra là bắt buộc.',
        'problem.test_cases.*.output.type.in' => 'Kiểu dữ liệu đầu ra không hợp lệ.',

        'problem.code-template.required' => 'Mã nguồn mẫu là bắt buộc.',
        'problem.code-template.min' => 'Mã nguồn mẫu không được để trống.',

        'newParam.name.required' => 'Tên tham số là bắt buộc.',
        'newParam.name.max' => 'Tên tham số không được vượt quá :max ký tự.',
        'newParam.type.required' => 'Kiểu dữ liệu tham số là bắt buộc.',
        'newParam.type.in' => 'Kiểu dữ liệu tham số không hợp lệ.',

        'newTestCase.inputs.*.value.required' => 'Giá trị đầu vào là bắt buộc.',
        'newTestCase.inputs.*.type.required' => 'Kiểu dữ liệu đầu vào là bắt buộc.',
        'newTestCase.inputs.*.type.in' => 'Kiểu dữ liệu đầu vào không hợp lệ.',
        'newTestCase.output.value.required' => 'Kết quả đầu ra mong đợi là bắt buộc.',
        'newTestCase.output.type.required' => 'Kiểu dữ liệu đầu ra là bắt buộc.',
        'newTestCase.output.type.in' => 'Kiểu dữ liệu đầu ra không hợp lệ.',
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
                    self::validateIdentifier('Tên hàm', $value, $fail);
                },
            ],
            'problem.return_type' => 'required|in:' . $allowedTypes,
            'problem.allowed_languages' => 'required|array|min:1|in:' . implode(',', array_keys(ProgrammingProblems::$SUPPORTED_LANGUAGES)),

            'problem.params' => [
                function ($attribute, $value, $fail) {
                    if (empty($value) || count(array_filter($value, fn($p) => !empty($p['name']) && !empty($p['type']))) === 0) {
                        $fail('Cần ít nhất một tham số cho bài tập này.');
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
            $fail("Định dạng không hợp lệ cho kiểu {$type}. Yêu cầu: {$typeMap[$type]['example']}");
        }
    }

    public static function validateIdentifier(string $attribute, string $value, \Closure $fail): void
    {
        if (!preg_match('/^[a-z][a-zA-Z0-9_]*$/', $value)) {
            $fail("{$attribute} phải bắt đầu bằng chữ cái viết thường và chỉ chứa chữ cái, chữ số hoặc dấu gạch dưới.");
            return;
        }
        $reserved = ['class', 'function', 'var', 'let', 'const', 'if', 'else', 'elseif', 'endif', 'switch', 'case', 'default', 'break', 'continue', 'return', 'for', 'foreach', 'while', 'do', 'endwhile', 'try', 'catch', 'finally', 'throw', 'new', 'public', 'private', 'protected', 'static', 'abstract', 'interface', 'extends', 'implements', 'trait', 'namespace', 'use', 'global', 'unset', 'true', 'false', 'null', 'void', 'int', 'float', 'string', 'bool', 'array', 'object', 'import', 'package', 'this', 'super', 'def', 'lambda', 'yield', 'await', 'async'];
        if (in_array(strtolower($value), $reserved, true)) {
            $fail("{$attribute} không được trùng với các từ khóa hệ thống.");
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
                    ProgrammingPracticeValidator::validateIdentifier('Tên tham số', $value, $fail);
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
                    ProgrammingPracticeValidator::validateIdentifier('Tên đầu vào', (string)$value, $fail);
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
                        $fail("Kiểu dữ liệu đầu vào phải khớp với kiểu tham số '{$expectedType}'.");
                    }
                },
            ],
            'newTestCase.inputs.*.value' => [
                'required',
                function ($attribute, $value, $fail) use ($newTestCase, $typeMap) {
                    $segments = explode('.', $attribute);
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
                function ($attribute, $value, $fail) use ($problem) {
                    $returnType = $problem['return_type'] ?? null;
                    if ($returnType && $value !== $returnType) {
                        $fail("Kiểu dữ liệu đầu ra phải khớp với kiểu trả về '{$returnType}'.");
                    }
                },
            ],
            'newTestCase.output.value' => [
                'required',
                function ($attribute, $value, $fail) use ($newTestCase, $typeMap, $problem) {
                    $type = data_get($newTestCase, 'output.type') ?: ($problem['return_type'] ?? null);
                    if ($type) {
                        ProgrammingPracticeValidator::validateValueByType($type, (string)$value, $fail, $typeMap);
                    }
                },
            ],
        ];
    }
}
