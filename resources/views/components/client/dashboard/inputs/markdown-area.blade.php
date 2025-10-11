<div class="course-field mb--30">
    <label>{{ $label }}</label>
    <div @class(['border border-danger' => $errors->has($name)])
         style="border-radius: 4px;">
        <div wire:ignore id="{{ $id }}-editor"></div>
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
        )
    </script>
@endpush
