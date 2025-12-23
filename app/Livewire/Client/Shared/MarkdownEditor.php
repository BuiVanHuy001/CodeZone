<?php

namespace App\Livewire\Client\Shared;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\Attributes\Modelable;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class MarkdownEditor extends Component {
    #[Modelable]
    public $value = '';

    public $label = '';
    public $name = '';
    public $id = '';
    public $placeholder = '';
    public $info = 'Bạn có thể sử dụng ngôn ngữ Markdown để định dạng nội dung.';

    #[Reactive]
    public $errorMessage = null;

    public function renderPreview()
    {
        if (empty($this->value)) {
            return '<p class="text-muted">Chưa có nội dung để xem trước.</p>';
        }

        return app(MarkdownRenderer::class)->toHtml($this->value);
    }

    public function render(): View
    {
        return view('livewire.client.shared.markdown-editor');
    }
}
