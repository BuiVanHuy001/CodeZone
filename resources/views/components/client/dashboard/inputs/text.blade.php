<div class="course-field mb--15">
    <label for="{{ $name }}">{{ $label }}</label>
    <input
        {{ $attributes->merge([
            'id' => $name,
            'name' => $name,
            'type' => $type,
            'placeholder' => $placeholder,
            'class' => ($isError ? 'mb-0 border-danger' : '')
        ]) }}
    >

    @error($name)
    <small class="text-danger d-block">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror
    @if($name === 'title' && isset($slug))
        <small class="mb-3">
            <i class="feather-info"></i> Permalink: https://codezone.com/course/{{ $slug }}
        </small>
    @else
        <small class="mb-3">
            <i class="feather-info"></i> {{ $info ?? 'This field is required.' }}
        </small>
    @endif
</div>
