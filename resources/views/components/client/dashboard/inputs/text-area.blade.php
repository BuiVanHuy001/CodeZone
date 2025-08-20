<div class="course-field mb--15">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea
        {{
            $attributes->merge([
                'id' => $name,
                'name' => $name,
                'rows' => $rows,
                'placeholder' => $placeholder,
                'wire:model' => 'model',
                ])
        }}
        @class([
            'mb-0',
            'border-danger' => $isError,
        ])
        ></textarea>
    <small class="d-block mt_dec--5"><i class="feather-info"></i> Enter for per line.</small>
</div>
