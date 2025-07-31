<?php

namespace App\Livewire\Client\Components\Course;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class DocumentBuilder extends Component
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
        $this->dispatch('builder-hided', $this->moduleIndex, $this->lessonIndex);
	}

    public function render(): View|Application|Factory
    {
	    return view('livewire.client.components.course.document-builder');
	}
}
