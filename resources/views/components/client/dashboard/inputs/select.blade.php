<div {{ $attributes->class(['course-field mb--20']) }}>
    <label for="{{ $name }}">{{ $label }}</label>
    <div
        wire:ignore
        class="rbt-modern-select bg-transparent height-45 w-100 mb--10"
        x-data
        x-init="
            $nextTick(() => {
                let select = $refs.select;
                $(select).selectpicker();
                $(select).on('changed.bs.select', function (e) {
                    @this.set('{{ $name }}', e.target.value);
                });
                Livewire.hook('message.processed', () => {
                    $(select).val(@this.get('{{ $name }}')).selectpicker('refresh');
                });
            });
        "
    >
        <select
            x-ref="select"
            id="{{ $name }}"
            class="w-100 {{ $isError ? 'border-danger' : '' }}"
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
            @elseif($name === 'problem.return_type')
                @foreach($options as $key => $type)
                    <option value="{{ $key }}">{{ $type['label'] }}</option>
                @endforeach
            @else
                @foreach ($options as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
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
