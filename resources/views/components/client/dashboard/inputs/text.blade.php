<div {{
    $attributes->class([
        'course-field mb--20'
        ])
    }}>
    <label for="{{ $name }}">{{ $label }}</label>
    <input
        wire:model.lazy="{{ $model }}"
        id="{{ $name }}"
        type="{{ $type }}
        placeholder="{{ $placeholder }}"
        @class([
            'mb-0',
            'border-danger' => $isError,
        ])
    >

    @error($model)
    <small class="text-danger d-block">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror

    @if($name === 'title' && empty($slug))
        <small class="mb-3">
            <i class="feather-info"></i> Permalink: https://codezone.com/course/{{ $slug }}
        </small>
    @elseif(!empty($info))
        <small class="mb-3">
            <i class="feather-info"></i> {!! $info !!}
        </small>
    @endif
</div>
