<div {{ $attributes->class(['course-field mb--20']) }}>
    <label>{{ $label }}</label>
    <div wire:ignore x-data x-init="$nextTick(() => $('select[data-live-search]').selectpicker('render'))"
         x-show="true"
        @class(['rbt-modern-select b-g-transparent height-45 w-100', 'border-danger' => $errors->has($name)])
    >
        <select class="w-100"
                data-live-search="true"
                x-ref="allowedLangs"
                multiple
                data-size="7"
                data-actions-box="true"
                data-selected-text-format="count > 2"
                @change="$wire.set('{{ $model }}', Array.from($refs.allowedLangs.selectedOptions).map(o => o.value))">
            @foreach($options as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>

    </div>
    @error($name)
    <small class="text-danger d-block">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror
    <small><i class="feather-info"></i> {{ $info }}</small>
</div>
