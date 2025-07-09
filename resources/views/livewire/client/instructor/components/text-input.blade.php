<div class="course-field mb--15">
    <label for="{{ $name }}">{{ $label }}</label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
           placeholder="{{ $placeholder }}"
           wire:model.live.debounce.250ms="model">
</div>
