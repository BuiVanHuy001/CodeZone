<div class="course-field mb--30">
    <label>{{ $label }}</label>
    <div wire:ignore id="{{ $id }}-editor"
        @class(['border-danger border' => $isError])
    ></div>
    <small><i class="feather-info"></i> {{ $info }}</small>
    @error($name)
    <small class="text-danger d-block">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror
</div>
