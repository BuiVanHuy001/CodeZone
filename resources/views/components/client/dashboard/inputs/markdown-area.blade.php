<div class="course-field mb--30">
    <label>{{ $label }}</label>
    <div wire:ignore id="{{ $id }}-editor"
    ></div>
    @error($name)
    <small class="text-danger d-block">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror
    <small><i class="feather-info"></i> {{ $info }}</small>
</div>
