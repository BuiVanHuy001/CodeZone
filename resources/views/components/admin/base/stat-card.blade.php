<div class="col-xl-3 col-md-6">
    <div class="card card-animate">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 overflow-hidden">
                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                        {{ $title }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <h5 class="{{ $changeColorClass }} fs-14 mb-0">
                        @if($changeIconClass)
                            <i class="{{ $changeIconClass }} fs-13 align-middle"></i>
                        @endif
                        {{ $change }}
                    </h5>
                </div>
            </div>
            <div class="d-flex align-items-end justify-content-between mt-4">
                <div>
                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                        @if($prefix)
                            {{ $prefix }}
                        @endif
                        <span class="counter-value" data-target="{{ $mainValue }}">0</span>

                        @if($suffix)
                            {{ $suffix }}
                        @endif
                    </h4>
                    <a href="{{ $linkUrl }}" class="text-decoration-underline">{{ $linkText }}</a>
                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title {{ $mainIconBgClass }} rounded fs-3">
                        <i class="bx {{ $mainIcon }} {{ $mainIconColorClass }}"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
