<?php

namespace App\Services\Course\Create\Builders\AssessmentTypes;

use App\Livewire\Client\CourseCreation\Components\Builders\Assessment\Programming;

class ProgrammingService {
    protected array $typeMap;

    public function __construct()
    {
        $this->typeMap = Programming::$typeMap;
    }

    public function makeCodeTemplate(array $allowedLanguages, $problem): array
    {
        $codeTemplates = [];
        foreach ($allowedLanguages as $language) {
            match ($language) {
                'js' => $codeTemplates['js'] = $this->makeJsTemplate($problem, $language),
                'java' => $codeTemplates['java'] = $this->makeJavaTemplate($problem, $language),
                'php' => $codeTemplates['php'] = $this->makePhpTemplate($problem, $language),
                'cpp' => $codeTemplates['cpp'] = $this->makeCppTemplate($problem, $language),
                default => $codeTemplates['python'] = $this->makePythonTemplate($problem, $language),
            };
        }
        return $codeTemplates;
    }

    private function makePythonTemplate(array $problem, string $language): string
    {
        $functionName = $problem['function_name'];
        $parameters = $this->normalizeParameter($problem['params'], $language);
        $returnType = $this->transformDatatype($problem['return_type'], $language);

        $needListImport = str_contains($parameters, 'List') || str_contains($returnType, 'List');
        $importLine = $needListImport ? "from typing import List\n\n" : "";
        return <<<PYTHON
{$importLine}class Solution:
    def {$functionName}(self, {$parameters}) -> {$returnType}:
        # TODO: implement your solution here
        pass

PYTHON;
    }

    private function makeJavaTemplate(array $problem, string $language): string
    {
        $functionName = $problem['function_name'];
        $parameters = $this->normalizeParameter($problem['params'], $language);
        $returnType = $this->transformDatatype($problem['return_type'], $language);

        return <<<JAVA
class Solution {
    public {$returnType} {$functionName}({$parameters}) {
        // TODO: implement your solution here
        return null;
    }
}
JAVA;
    }

    private function makePhpTemplate(array $problem, string $language): string
    {
        $functionName = $problem['function_name'];
        $parameters = $this->normalizeParameter($problem['params'], $language);
        $returnType = $this->transformDatatype($problem['return_type'], $language);
        $defaultReturn = $this->defaultReturnValue($problem['return_type'], $language);

        return <<<PHP
<?php
class Solution {
    public function {$functionName}({$parameters}): {$returnType} {
        // TODO: implement your solution here
        return {$defaultReturn};
    }
}
PHP;
    }

    private function makeJsTemplate(array $problem, string $language): string
    {
        $functionName = $problem['function_name'];
        $parameters = $this->normalizeParameter($problem['params'], $language);
        $returnType = $this->transformDatatype($problem['return_type'], $language);
        $defaultReturn = $this->defaultReturnValue($problem['return_type'], $language);
        $jsDoc = $this->makeJsDoc($problem['params'], $problem['return_type'], $language);

        return <<<JS
class Solution {
    {$jsDoc}
    {$functionName}({$parameters}) {
        // TODO: implement your solution here
        return {$defaultReturn};
    }
}
JS;
    }

    private function makeCppTemplate(array $problem, string $language): string
    {
        $functionName = $problem['function_name'];
        $parameters = $this->normalizeParameter($problem['params'], $language);
        $returnType = $this->transformDatatype($problem['return_type'], $language);
        $defaultReturn = $this->defaultReturnValue($problem['return_type'], $language);

        return <<<CPP
#include <vector>
using namespace std;

class Solution {
public:
    {$returnType} {$functionName}({$parameters}) {
        // TODO: implement your solution here
        return {$defaultReturn};
    }
};
CPP;
    }

    private function makeJsDoc(array $params, string $returnType, string $language): string
    {
        $lines = ["/**"];

        foreach ($params as $param) {
            $type = $this->transformDatatype($param['type'], $language);
            $lines[] = " * @param {{$type}} {$param['name']}";
        }

        $retType = $this->transformDatatype($returnType, $language);
        $lines[] = " * @return {{$retType}}";
        $lines[] = " */";

        return implode("\n    ", $lines); // indent đẹp với class body
    }

    private function normalizeParameter(array $params, string $language): string
    {
        $convertedParams = '';

        foreach ($params as $param) {
            $type = $this->transformDatatype($param['type'], $language);
            $name = $param['name'];

            $convertedParams .= match ($language) {
                'python' => "{$name}: {$type}, ",
                'php' => "{$type} \${$name}, ",
                'cpp', 'java' => "{$type} {$name}, ",
                default => "{$name}, ",
            };
        }

        return rtrim($convertedParams, ', ');
    }

    private function transformDatatype(string $type, string $language): string
    {
        return $this->typeMap[$type][$language] ?? $type;
    }

    private function defaultReturnValue(string $type, string $language): string
    {
        $map = [
            'int' => ['php' => '0', 'java' => '0', 'cpp' => '0', 'python' => '0', 'js' => '0'],
            'float' => ['php' => '0.0', 'java' => '0.0', 'cpp' => '0.0', 'python' => '0.0', 'js' => '0.0'],
            'bool' => ['php' => 'false', 'java' => 'false', 'cpp' => 'false', 'python' => 'False', 'js' => 'false'],
            'string' => ['php' => '""', 'java' => '""', 'cpp' => '""', 'python' => '""', 'js' => '""'],
            'int[]' => ['php' => '[]', 'java' => 'new int[0]', 'cpp' => '{}', 'python' => '[]', 'js' => '[]'],
            'float[]' => ['php' => '[]', 'java' => 'new double[0]', 'cpp' => '{}', 'python' => '[]', 'js' => '[]'],
            'string[]' => ['php' => '[]', 'java' => 'new String[0]', 'cpp' => '{}', 'python' => '[]', 'js' => '[]'],
            'bool[]' => ['php' => '[]', 'java' => 'new boolean[0]', 'cpp' => '{}', 'python' => '[]', 'js' => '[]'],
        ];

        return $map[$type][$language] ?? 'null';
    }
}
