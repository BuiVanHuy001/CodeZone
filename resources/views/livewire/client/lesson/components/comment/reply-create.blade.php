<div class="inner rbt-default-form p-3 pt-4 d-flex align-items-center gap-2">
    <div class="form-group mb-0 flex-grow-1">
        <input @class([
                'form-control m-0',
                'border-danger' => $errors->has('content'),
            ])
               wire:model.live.debounce.250ms="content" name="comment" placeholder="Reply to {{ $parentComment->user->name }}..."/>
    </div>

    <button
        @disabled(!$canSubmit)
        wire:click="submitComment"
        class="rbt-btn btn-sm btn-gradient rounded-circle d-flex align-items-center justify-content-center"
        type="submit" style="width: 40px; height: 40px;">
        <span class="btn-icon"><i class="feather-arrow-right-circle p-0"></i></span>
    </button>
</div>
