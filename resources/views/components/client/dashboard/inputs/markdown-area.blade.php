<div class="course-field mb--30">
    <label>{{ $label }}</label>
    <div @class(['border border-danger' => $isError])
         style="border-radius: 4px;">
        <div wire:ignore id="{{ $id }}-editor"
        ></div>
    </div>
    @error($name)
    <small class="text-danger d-block">
        <i class="feather-alert-triangle"></i> {{ $errors->first($name) }}
    </small>
    @enderror
    <small><i class="feather-info"></i> {{ $info }}</small>
</div>
