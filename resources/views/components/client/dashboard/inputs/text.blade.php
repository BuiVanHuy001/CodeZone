<div {{
    $attributes->class([
        'course-field mb--20'
        ])
    }}>
    <label for="{{ $name }}">{{ $label }}</label>
    <input
        wire:model.lazy="{{ $model }}"
        type="{{ $type }}"
        @if($type === 'date')
            min="{{ now()->format('Y-m-d') }}"
        @endif
        placeholder="{{ $placeholder }}"
        value="{{ $value }}"
        @class([
            'mb-0',
            'border-danger' => $errors->has($name),
        ])
    >

    @error($name)
    <small class="text-danger d-block">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror

    @if($name === 'title')
        <small class="mb-3">
            <i class="feather-info"></i> Permalink: https://codezone.com/course/{{ $slug }}
        </small>
        <br/>
    @endif
    @if(!empty($info))
        <small class="mb-3">
            <i class="feather-info"></i> {!! $info !!}
        </small>
    @endif
</div>
