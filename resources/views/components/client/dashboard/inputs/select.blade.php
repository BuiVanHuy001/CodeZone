<div {{ $attributes->class(['course-field mb--20']) }}>
    @if($name !== 'languageSelected')
        <label for="{{ $name }}">{{ $label }}</label>
    @else
        <h5>{{ $label }}</h5>
    @endif
    @if($isBoostrapSelect)
        <div wire:ignore
             class="rbt-modern-select bg-transparent height-45 w-100 mb--10"
             x-data
             x-init="
         $nextTick(() => {
         let select = $refs.select;
         $(select).selectpicker();
         $(select).on('changed.bs.select', function (e) {
            @this.set('{{ $name }}', e.target.value);
             });
         });"
        >
            <select
                wire:model="{{ $name }}"
                x-ref="select"
                id="{{ $name }}"
                @class([
                    'w-100',
                    'border-danger' => $errors->has($name),
                ])
            >
                <option value="" disabled>{{ $placeholder }}</option>

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
                @elseif($name === 'languageSelected')
                    @foreach($options as $type)
                        <option @checked(isset($default) && $default === $type)
                                value="{{ $type }}">{{ \App\Models\ProgrammingAssignmentDetails::$SUPPORTED_LANGUAGES[$type] }}</option>
                    @endforeach
                @else
                    @foreach ($options as $key => $label)
                        <option value="{{ $key }}">{{ ucfirst($label) }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    @else
        <select wire:model.lazy="{{ $name }}"
            @class([
                'w-100',
                'border-danger' => $errors->has($name),
            ])
        >
            <option value="">Select lesson type</option>
            @foreach($options  as $key => $type)
                <option value="{{ $key }}">{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    @endif

    @error($name)
    <small class="text-danger d-block">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror
    <small><i class="feather-info"></i> {{ $info }}</small>
</div>
