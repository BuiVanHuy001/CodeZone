<div {{ $attributes->class(['course-field mb--20']) }}>
    @if($name !== 'languageSelected')
        <label for="{{ $name }}">{{ $label }}</label>
    @else
        <h5>{{ $label }}</h5>
    @endif
        <div class="rbt-modern-select bg-transparent w-100">
            <select
                wire:model.live="{{ $name }}"
                id="{{ $name }}"
                @class([
                    'w-100 h-100',
                    'is-invalid border-danger' => $errors->has($name),
                ])
                style="cursor: pointer;"
            >
                @if($placeholder)
                    <option value="" disabled selected>{{ $placeholder }}</option>
                @endif

                @foreach($normalizedOptions as $option)
                    @if($option['is_group'])
                        <optgroup label="{{ $option['label'] }}">
                            @foreach($option['options'] as $child)
                                <option value="{{ $child['value'] }}">
                                    {{ $child['label'] }}
                            </option>
                        @endforeach
                        </optgroup>
                @else
                        <option value="{{ $option['value'] }}">
                            {{ $option['label'] }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

    @error($name)
        <small class="text-danger d-block mt-1">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror

        @if($info)
            <small class="text-muted"><i class="feather-info"></i> {{ $info }}</small>
        @endif
</div>
