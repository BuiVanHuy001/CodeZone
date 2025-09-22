<div class="bg-color-extra2 ptb--15 overflow-hidden">
    <div class="rbt-button-group">
        <button wire:click="prevLesson" @class([
            'rbt-btn icon-hover icon-hover-left btn-md bg-primary-opacity',
            'disabled cursor-not-allowed' => !$prevRoute,
        ])
        aria-disabled="{{ $prevRoute ? 'false' : 'true' }}">
            <span class="btn-icon"><i class="feather-arrow-left"></i></span>
            <span class="btn-text">Previous</span>
        </button>

        <button wire:click="nextLesson" href="{{ $nextRoute ?? 'javascript:void(0)' }}" @class([
            'rbt-btn icon-hover btn-md',
            'disabled cursor-not-allowed' => !$nextRoute,
        ])
        aria-disabled="{{ $nextRoute ? 'false' : 'true' }}">
            <span class="btn-text">Next</span>
            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
        </button>
    </div>
</div>
