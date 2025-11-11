<div>
    @foreach(\App\Support\ClientMenuMapping::getMenuForRole() as $section => $items)
        <ul class="user-list-wrapper">
            @foreach($items as $label => $item)
                <li>
                    <a href="{{ route($item['route']) }}" wire:navigate>
                        <i class="{{ $item['icon'] }}"></i>
                        <span>{{ $label }}</span>
                    </a>
                </li>
            @endforeach
        </ul>

        @unless($loop->last)
            <hr class="mt--10 mb--10">
        @endunless
    @endforeach

    <ul class="user-list-wrapper">
        <li>
            <a href="{{ route('client.logout') }}">
                <i class="feather-log-out"></i><span>Logout</span>
            </a>
        </li>
    </ul>
</div>
