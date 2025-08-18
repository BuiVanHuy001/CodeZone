<div class="course-field mb--15">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea id="{{ $name }}" rows="{{ $rows }}" wire:model="model" placeholder="{{ $placeholder }}"></textarea>
    <small class="d-block mt_dec--5"><i class="feather-info"></i> Enter for per line.</small>
</div>
