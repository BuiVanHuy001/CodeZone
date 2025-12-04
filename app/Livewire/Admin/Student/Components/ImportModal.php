<?php

namespace App\Livewire\Admin\Student\Components;

use App\Services\Admin\Student\StudentService;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Log;

class ImportModal extends Component {
    use WithFileUploads;

    public $files = [];
    public bool $showResult = false;
    public array $importedStudents = [];
    public array $importErrors = [];

    protected function rules(): array
    {
        return [
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimes:csv,xls,xlsx|max:10240',
        ];
    }

    protected $messages = [
        'files.*.mimes' => 'File phải có định dạng: csv, xls, xlsx',
        'files.*.max' => 'File không được vượt quá 10MB',
    ];

    public function updatedFiles(): void
    {
        $this->validate($this->rules(), $this->messages);
    }

    public function importStudents(): void
    {
        $this->validate();

        try {
            $result = app(StudentService::class)->importStudent($this->files);
            $this->files = [];
            if ($result->count > 0) {
                $this->importedStudents = $result->importedData;
                $this->showResult = true;
            }
            $this->dispatch('student-imported');
            $this->handleImportResponse($result);
        } catch (\Exception $e) {
            $this->swal('error', 'Lỗi hệ thống', 'Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại.');
        }
    }

    private function handleImportResponse($result): void
    {
        if ($result->hasErrors()) {
            $this->importErrors = $result->errors;
        }

        if ($result->isSuccess()) {
            $this->swal('Import thành công', 'Tất cả sinh viên đã được import thành công.');
            return;
        }

        $message = $result->count > 0
            ? "Đã import {$result->count} sinh viên, nhưng có một số lỗi:"
            : "Không thể import sinh viên. Vui lòng kiểm tra lỗi sau:";

        $errorHtml = $this->buildErrorHtml($result->errors);

        $this->swal(
            title: 'Kết quả Import',
            icon: $result->count > 0 ? 'warning' : 'error',
            html: $message . $errorHtml,
            showCloseButton: true,
        );
    }

    private function buildErrorHtml(array $errors): string
    {
        $limit = 10;
        $visibleErrors = array_slice($errors, 0, $limit);

        $listItems = collect($visibleErrors)
            ->map(fn($err) => "<li class='text-start'>" . e($err) . "</li>")
            ->join('');

        if (count($errors) > $limit) {
            $listItems .= "<li>... và " . (count($errors) - $limit) . " lỗi khác.</li>";
        }

        return "<ul style='margin-top:10px; max-height: 200px; overflow-y: auto;'>{$listItems}</ul>";
    }

    public function removeFile(int $index): void
    {
        if (isset($this->files[$index])) {
            $file = $this->files[$index];

            if ($file && method_exists($file, 'delete')) {
                try {
                    $file->delete();
                } catch (\Exception $e) {
                    Log::warning('Không thể xóa file tạm: ' . $e->getMessage());
                }
            }

            unset($this->files[$index]);
            $this->files = array_values($this->files);
        }
    }

    public function closeModal(): void
    {
        if ($this->files) {
            foreach ($this->files as $file) {
                if ($file && method_exists($file, 'delete')) {
                    try {
                        $file->delete();
                    } catch (\Exception $e) {
                        Log::warning('Không thể xóa file tạm: ' . $e->getMessage());
                    }
                }
            }
        }

        $this->reset(['showResult', 'importedStudents', 'importErrors', 'files']);
        $this->resetValidation();

        $this->dispatch('close-modal', id: 'importStudentModal');
    }

    public function render(): View
    {
        return view('livewire.admin.student.components.import-modal');
    }
}
