<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Document extends Component
{
	public int $moduleIndex;
	public int $lessonIndex;
	public string $document;

	public function saveDocument(): void
	{
		if (empty($this->document)) {
			$this->dispatch('swal', [
				'title' => 'Document Required',
				'text' => 'Please provide a document content.',
				'icon' => 'warning',
				'timer' => 3000,
				'showConfirmButton' => false
			]);
			return;
		}
		$this->dispatch('document-saved',
			moduleIndex: $this->moduleIndex,
			lessonIndex: $this->lessonIndex,
			document: $this->document
		);
	}

	public function removeContent(): void
	{
        $this->reset('content');
        $this->dispatch('builders-hided', $this->moduleIndex, $this->lessonIndex);
	}

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.document');
	}
}
