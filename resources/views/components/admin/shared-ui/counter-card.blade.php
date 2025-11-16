<div {{ $attributes->class([
        'col col-lg',
        'border-end' => $border,
    ])
}}>
    <div class="py-4 px-3">
        <h5 class="text-{{ $color }} text-uppercase fs-13">
            {{ $title }}
        </h5>
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <i class="{{ $icon }} display-6 text-{{ $color }}"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <h2 class="mb-0 text-{{ $color }}">
                    <span class="counter-value" data-target="{{ $count }}">0</span>
                </h2>
            </div>
        </div>
    </div>
</div>
