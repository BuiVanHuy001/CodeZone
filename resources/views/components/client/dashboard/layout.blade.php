<x-layouts.app>
    @persist('header')
    <x-header/>
    <div class="rbt-page-banner-wrapper">
        <div class="rbt-banner-image"></div>
    </div>
    @endpersist
    <div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @persist('dashboard.banner-top')
                    <x-dashboard.banner-top/>
                    @endpersist
                    <div class="row g-5">
                        <div class="col-lg-3">
                            <livewire:client.instructor.sidebar wire:scroll/>
                        </div>

                        <div class="col-lg-9">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @persist('footer')
    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>
    <x-footer/>
    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
        </svg>
    </div>
    @endpersist
</x-layouts.app>
