<div class="course-field mb--20">
    <label for="{{ $name }}">{{ $label }}</label>
    <div class="rbt-modern-select bg-transparent height-45">
        <select wire:ignore.self
            {{ $attributes->merge([
                'id' => $name,
                'name' => $name,
                'class' => 'form-select',
                'wire:model' => 'model',
                'placeholder' => $placeholder,
                'class' => ($isError ? 'mb-0 border-danger ' : '') . 'w-100'
            ]) }}
        >
            <option value="">{{ $placeholder }}</option>
            @if($name === 'category')
                @foreach ($options as $category)
                    @foreach ($category->getChildren($category->id) as $children)
                        <option value="{{ $children->id }}">
                            {{ $category->name . '->' . $children->name }}
                        </option>
                    @endforeach
                @endforeach
            @else
                <option value="">{{ $placeholder }}</option>
                @foreach ($options as $option)
                    <option value="{{ $option }}">
                        {{ ucfirst($option) }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
    @error($name)
    <small class="text-danger d-block">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror
    <small><i class="feather-info"></i> {{ $info }}</small>
</div>
