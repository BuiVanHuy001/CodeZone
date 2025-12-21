<div class="course-field mb--30">
    <label>{{ $label }}</label>
    <div class="rbt-tab-inner rbt-tab-animation p-0">
        <div class="d-flex justify-content-end mb-2">
            <ul class="nav nav-tabs button-group border-0" role="tablist">
                <li class="nav-item">
                    <button class="rbt-btn btn-sm btn-outline-primary active"
                            data-bs-toggle="tab" data-bs-target="#{{ $id }}-edit" type="button" role="tab" aria-controls="{{ $id }}-edit" aria-selected="true">
                        <i class="feather-edit"></i> Chỉnh sửa
                    </button>
                </li>
                <li class="nav-item">
                    <button class="rbt-btn btn-sm btn-outline-primary"
                            data-bs-toggle="tab" data-bs-target="#{{ $id }}-preview" type="button" role="tab" aria-controls="{{ $id }}-preview" aria-selected="false"
                            wire:click.prevent="renderMarkdownPreview('{{ $name }}')">
                        <i class="feather-eye"></i> Xem trước
                    </button>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="{{ $id }}-tabContent">
            <div @class(['tab-pane fade show active', 'border border-danger' => $errors->has($name)])
                 id="{{ $id }}-edit" role="tabpanel" aria-labelledby="{{ $id }}-edit-tab"
                 style="border-radius: 4px;">
                <div wire:ignore id="{{ $id }}-editor"></div>
            </div>

            <div class="tab-pane fade" id="{{ $id }}-preview" role="tabpanel" aria-labelledby="{{ $id }}-preview-tab">
                <div id="{{ $id }}-preview-content"
                     class="rbt-default-form p-3 border rounded">
                    <p class="text-muted">Đang chờ nội dung xem trước...</p>
                </div>
            </div>
        </div>
    </div>

    @error($name)
    <small class="text-danger d-block">
        <i class="feather-alert-triangle"></i> {{ $errors->first($name) }}
    </small>
    @enderror
    <small><i class="feather-info"></i> {{ $info }}</small>
</div>

@push('scripts')
    <script type="module">
        createCodeEditor(
            '{{ $id }}-editor',
            'markdown',
            @json($doc ?? '', JSON_THROW_ON_ERROR),
            false,
            @json($livewireComponentId ?? null, JSON_THROW_ON_ERROR),
            @json($name, JSON_THROW_ON_ERROR)
        );

        window.renderMarkdownPreview = (componentId, propertyName) => {
            Livewire.find(componentId).call('renderPreview', propertyName)
                .then(htmlContent => {
                    document.getElementById('{{ $id }}-preview-content').innerHTML = htmlContent;
                });
        }
    </script>
@endpush
