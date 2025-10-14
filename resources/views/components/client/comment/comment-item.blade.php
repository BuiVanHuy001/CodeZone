<li class="comment position-relative">
    @if(auth()->user()->id === $comment->user->id)
        <button class="btn btn-light btn-sm position-absolute translate-middle shadow-sm rounded-circle border-0 text-muted hover:text-danger"
                style="width:28px;height:28px; top: 20px; right: 0;"
                wire:click.prevent="deleteComment({{ $comment->id }})">
            <i class="feather-x"></i>
        </button>
    @endif

    <div class="comment-body">
        <div class="single-comment d-flex">
            <div class="comment-img position-relative">
                @if($comment->user->isInstructor())
                    <span class="position-absolute top-0 translate-middle">
                       <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.78552 9.5 12.7855 14l9-4.5-9-4.5-8.99998 4.5Zm0 0V17m3-6v6.2222
                                c0 .3483 2 1.7778 5.99998 1.7778 4 0 6-1.3738 6-1.7778V11"/>
                        </svg>
                    </span>
                @endif
                <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" loading="lazy" class="rounded-circle" width="32" height="32">
            </div>
            <div class="comment-inner flex-grow-1">
                <h6 class="commenter mb-1">
                    <a href="#" class="fw-semibold text-dark">{{ $comment->user->name }}</a>
                </h6>
                <div class="comment-meta small text-muted d-flex align-items-center gap-2">
                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                    <span>•</span>
                    <a class="text-decoration-none text-primary cursor-pointer" wire:click.prevent="showReplyForm({{ $comment->id }})">Reply</a>
                </div>
                <p class="mb-0 mt-1" wire:ignore>{!! $comment->content !!}</p>
                <livewire:client.shared.reaction-box :model="$comment" wire:key="reaction-comment-{{ $comment->id }}"/>
            </div>
        </div>
    </div>

    @if($replyingTo === $comment->id)
        <livewire:client.lesson.components.comment.reply-create
            :parentComment="$comment"
            :isLastLevel="true"
            wire:key="reply-{{ $comment->id }}"
        />
    @endif
</li>
