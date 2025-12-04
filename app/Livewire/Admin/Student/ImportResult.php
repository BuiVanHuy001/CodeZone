<?php

namespace App\Livewire\Admin\Student;

use Illuminate\Support\Collection;

class ImportResult {
    public int $count = 0;
    public array $errors = [];
    public array $details = [];
    public array $importedData = [];

    public function addSuccess(array|Collection $models, string $fileName): void
    {
        $count = count($models);
        $this->count += $count;
        $this->details[] = "File {$fileName}: Imported {$count} records.";

        $this->importedData = array_merge($this->importedData, $models);
    }

    public function addError(string $fileName, string|array $error): void
    {
        if (is_array($error)) {
            foreach ($error as $e) {
                $this->errors[] = "File {$fileName}: {$e}";
            }
        } else {
            $this->errors[] = "File {$fileName}: {$error}";
        }
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function isSuccess(): bool
    {
        return $this->count > 0 && empty($this->errors);
    }
}
