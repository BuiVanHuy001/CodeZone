<div class="course-field mb--30">
    @if($label)
        <label class="form-label fw-bold mb-2">{{ $label }}</label>
    @endif

    <div x-data="{
            tab: 'write',
            previewContent: '',
            async loadPreview() {
                this.previewContent = 'Đang tải...';
                try {
                    let html = await $wire.renderPreview();
                    this.previewContent = html;
                } catch (e) {
                    this.previewContent = '<span class=\'text-danger\'>Lỗi tải preview.</span>';
                }
            }
         }"
         class="github-editor rounded-2 border">
        <div class="editor-header d-flex align-items-center px-2 pt-2 bg-light border-bottom">
            <button type="button" @click="tab = 'write'" :class="{ 'active-tab': tab === 'write' }" class="btn-tab me-1">
                Chỉnh sửa
            </button>
            <button type="button" @click="tab = 'preview'; loadPreview()" :class="{ 'active-tab': tab === 'preview' }" class="btn-tab">
                Xem trước
            </button>
        </div>

        <div class="editor-body bg-white rounded-bottom-2">
            <div x-show="tab === 'write'"
                 class="p-0 {{ $errorMessage ? 'border border-danger rounded' : '' }}">
                <div wire:ignore
                     id="{{ $id ?: 'markdown-editor' }}"
                     style="height: 300px; position: relative; overflow: hidden; border-radius: 0 0 4px 4px;">
                </div>
            </div>

            <div x-show="tab === 'preview'" style="display: none;">
                <div class="markdown-body p-3 overflow-auto custom-scrollbar"
                     x-html="previewContent"
                     style="height: 300px;">
                </div>
            </div>
        </div>
    </div>
    @if($errorMessage)
        <small class="text-danger d-block mt-2">
            <i class="feather-alert-triangle"></i> {{ $errorMessage }}
        </small>
    @endif

    @if($info)
        <small class="text-muted d-block mt-2"><i class="feather-info"></i> {{ $info }}</small>
    @endif

</div>

@assets
<style>
    .github-editor {
        border-color: #d0d7de !important;
    }

    .editor-header {
        background-color: #f6f8fa;
        border-bottom-color: #d0d7de !important;
    }

    .btn-tab {
        padding: 8px 16px;
        color: #57606a;
        background: transparent;
        font-weight: 500;
        border: 1px solid transparent;
        border-radius: 6px 6px 0 0;
        transition: none;
        font-size: 14px;
    }

    .btn-tab:hover {
        color: #24292f;
        background: rgba(0, 0, 0, 0.05);
    }

    .active-tab {
        background-color: #ffffff !important;
        border-color: #d0d7de !important;
        border-bottom-color: #ffffff !important;
        color: #24292f !important;
        z-index: 10;
        position: relative;
        bottom: -1px;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 4px;
    }
</style>
@endassets

@script
<script>
    createCodeEditor(
        '{{ $id ?: "markdown-editor" }}',
        'markdown',
        $wire.value,
        false,
        $wire.$id,
        'value'
    );
</script>
@endscript
