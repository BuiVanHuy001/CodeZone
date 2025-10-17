<div class="filter-select-option">
    <div class="filter-select rbt-modern-select">
        <span class="select-label d-block">{{ $label }}</span>
        @if($isModern)
            <select data-live-search="true"
                    title="{{ $placeholder }}"
                    multiple
                    data-size="7"
                    data-actions-box="true"
                    data-selected-text-format="count > 2"
                    @if($name === 'instructor')
                        name="{{ $name }}[]"
                    @else
                        name="{{ $name }}"
                @endif
            >
                @foreach($items as $item)
                    <option @selected(is_array($selectedValue) && in_array($item->id, $selectedValue, true))
                            value="{{ $item->id }}"
                            data-subtext="{{ $item->rating }}">
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        @else
            <select name="{{ $name }}">
                @if($name === 'category')
                    <option value="all">All</option>
                @endif
                @foreach($items as $key => $item)
                    <option @selected($key === $selectedValue) value="{{ $key }}">{{ $item->name ?? $item }}</option>
                @endforeach
            </select>
        @endif
    </div>
</div>
