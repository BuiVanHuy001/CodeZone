<?php

namespace App\Livewire\Admin\Student\Components;

use App\Imports\StudentImport;
use App\Services\Admin\Student\StudentService;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportModal extends Component {
    use WithFileUploads;

    public $files = [];
    public array $uploadedFiles = [];

    protected $listeners = ['closeModal'];

    public function updatedFiles(): void
    {
        $this->validate([
            'files.*' => 'required|file|mimes:csv,xls,xlsx|max:10240',
        ], [
            'files.*.required' => 'File không được để trống',
            'files.*.file' => 'File không hợp lệ',
            'files.*.mimes' => 'File phải có định dạng: csv, xls, xlsx',
            'files.*.max' => 'File không được vượt quá 10MB',
        ]);
    }

    public function importStudents(): void
    {
        \Log::info('ImportModal: importStudents() called');

        $this->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimes:csv,xls,xlsx|max:10240',
        ]);

        \Log::info('ImportModal: Validation passed, files count: ' . count($this->files));

        foreach ($this->files as $index => $file) {
            \Log::info("ImportModal: File {$index} - Name: {$file->getClientOriginalName()}, Size: {$file->getSize()}, Path: {$file->getRealPath()}");
        }

        $result = app(StudentService::class)->importStudent($this->files);

        \Log::info('ImportModal: Import completed', $result);

        $totalImported = $result['totalImported'];
        $allErrors = $result['errors'];
        $fileResults = $result['fileResults'];

        $this->reset(['files']);

        if ($totalImported > 0) {
            $message = "Successfully imported {$totalImported} student(s) from " . count($fileResults) . " file(s).";

            if (!empty($allErrors)) {
                $message .= " However, there were " . count($allErrors) . " error(s).";

                // Build an HTML list of errors (escape each error). Limit visible errors to 20.
                $visibleErrors = array_slice($allErrors, 0, 20);
                $errorItems = '';
                foreach ($visibleErrors as $err) {
                    $errorItems .= '<li>' . e($err) . '</li>';
                }
                if (count($allErrors) > 20) {
                    $errorItems .= '<li>... and ' . (count($allErrors) - 20) . ' more errors.</li>';
                }
                $errorHtml = '<br><small>Errors:</small><ul style="text-align:left;margin:0.5rem 0 0 1rem;">' . $errorItems . '</ul>';

                $this->dispatch('swal', [
                    'icon' => 'warning',
                    'title' => 'Import Completed with Warnings',
                    'html' => $message . $errorHtml,
                    'confirmButtonText' => 'OK',
                ]);

                logger()->error('Student import errors:', $allErrors);
            } else {
                $this->dispatch('swal', [
                    'icon' => 'success',
                    'title' => 'Import Successful',
                    'text' => $message,
                    'timer' => 3000,
                    'showConfirmButton' => false,
                ]);
            }

            // Refresh parent component data
            $this->dispatch('students-imported');

        } else {
            $errorMessage = "No students were imported.";
            if (!empty($allErrors)) {
                $errorMessage .= "\n\nErrors:\n" . implode("\n", array_slice($allErrors, 0, 5));
                if (count($allErrors) > 5) {
                    $errorMessage .= "\n... and " . (count($allErrors) - 5) . " more errors.";
                }
            }

            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Import Failed',
                'html' => nl2br($errorMessage),
            ]);

            logger()->error('Student import failed:', $allErrors);
        }

        $this->dispatch('close-modal');
    }

    public function removeFile(int $index): void
    {
        if (isset($this->files[$index])) {
            unset($this->files[$index]);
            $this->files = array_values($this->files); // Re-index array
        }
    }

    public function closeModal(): void
    {
        $this->reset(['files', 'uploadedFiles']);
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.admin.student.components.import-modal');
    }
}
