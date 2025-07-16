<div class="course-field mb--20">
    <label for="{{ $name }}">{{ $label }}</label>
    <div class="rbt-modern-select bg-transparent height-45 mb--10">
        <select wire:model="model" id="{{ $name }}" name="{{ $name }}" class="w-100">
            <option value="">Course Level</option>
            @foreach ($options as $option)
                <option value="{{ $option }}">
                    {{ ucfirst($option) }}
                </option>
            @endforeach
        </select>
    </div>
    <small><i class="feather-info"></i> Course difficulty level</small>
</div>
