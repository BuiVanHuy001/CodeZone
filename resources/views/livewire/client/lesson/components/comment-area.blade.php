<div class="rbt-comment-area">

    <a class="rbt-btn-link text-end" wire:click.prevent="$dispatch('open-modal', { id: 'commentList' })">{{ $commentCountText }}</a>
    <div wire:ignore.self class="rbt-default-modal modal fade" id="commentList" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="height: 95%">
                <div class="modal-header">
                    <button wire:click="$dispatch('close-modal', { id: 'commentList' })" type="button" class="rbt-round-btn">
                        <i class="feather-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="inner rbt-default-form">
                        <ul class="comment-list">
                            @forelse($comments as $comment)
                                <li class="comment position-relative" wire:key="comment-{{ $comment->id }}">
                                    @if(auth()->user()->id === $comment->user->id)
                                        <button
                                            class="btn btn-light btn-sm position-absolute translate-middle shadow-sm rounded-circle border-0 text-muted hover:text-danger"
                                            style="width:28px;height:28px; top: 20px; right: 0;"
                                            wire:click.prevent="deleteComment({{ $comment->id }})"
                                        >
                                            <i class="feather-x"></i>
                                        </button>
                                    @endif

                                    <div class="comment-body">
                                        <div class="single-comment d-flex">
                                            <div class="comment-img position-relative me-3">
                                                @if($comment->user->hasRole('instructor'))
                                                    <span class="position-absolute top-0 translate-middle">
                                                       <svg class="text-primary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.78552 9.5 12.7855 14l9-4.5-9-4.5-8.99998 4.5Zm0 0V17m3-6v6.2222c0 .3483 2 1.7778 5.99998 1.7778 4 0 6-1.3738 6-1.7778V11"/>
                                                        </svg>
                                                    </span>
                                                @endif
                                                <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" loading="lazy" class="rounded-circle" width="45" height="45">
                                            </div>

                                            <div class="comment-inner flex-grow-1">
                                                <h6 class="commenter mb-1">
                                                    <a href="{{ $comment->user->profileUrl ?? '#' }}" class="fw-semibold text-dark">
                                                        {{ $comment->user->name }}
                                                    </a>
                                                </h6>
                                                <div class="comment-meta small text-muted d-flex align-items-center gap-2">
                                                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                                                    <span>•</span>
                                                    <a href="#" class="text-primary" wire:click.prevent="showReplyForm({{ $comment->id }})">Reply</a>
                                                </div>
                                                <div class="comment-text mt-1">
                                                    <p class="mb-0">{!! $comment->content !!}</p>
                                                </div>
                                                <livewire:client.shared.reaction-box
                                                    :model="$comment"
                                                    wire:key="reaction-comment-{{ $comment->id }}"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    @if($replyingTo === $comment->id)
                                        <livewire:client.lesson.components.comment.reply-create
                                            :$lesson
                                            :parentComment="$comment"
                                            wire:key="reply-{{ $comment->id }}"
                                        />
                                    @endif

                                    @if($comment->replies->count() > 0)
                                        @if(empty($loadedReplies[$comment->id]))
                                            <a
                                                class="rbt-btn-link d-inline-flex align-items-center gap-1"
                                                wire:click.prevent="loadReplies({{ $comment->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="loadReplies({{ $comment->id }})"
                                            >
                                                <span wire:loading.remove wire:target="loadReplies({{ $comment->id }})">
                                                    View {{ Str::plural(count($comment->replies) . ' reply') }}
                                                </span>

                                                <span class="spinner-border spinner-border-sm text-primary"
                                                      wire:loading
                                                      wire:target="loadReplies({{ $comment->id }})"
                                                      role="status"
                                                      aria-hidden="true"></span>

                                                <span wire:loading wire:target="loadReplies({{ $comment->id }})">Loading...</span>
                                            </a>
                                        @else
                                            <ul class="children">
                                                @foreach($loadedReplies[$comment->id] as $reply)
                                                    <li class="comment position-relative">
                                                        @if(auth()->user()->id === $reply->user->id)
                                                            <button
                                                                class="btn btn-light btn-sm position-absolute translate-middle shadow-sm rounded-circle border-0 text-muted hover:text-danger"
                                                                style="width:28px;height:28px; top: 20px; right: 0;"
                                                                wire:click.prevent="deleteComment({{ $reply->id }})"
                                                            >
                                                                <i class="feather-x"></i>
                                                            </button>
                                                        @endif

                                                            <div class="comment-body">
                                                            <div class="single-comment d-flex">
                                                                <div class="comment-img position-relative">
                                                                    @if($reply->user->hasRole('instructor'))
                                                                        <span class="position-absolute top-0 translate-middle">
                                                                       <svg class="text-primary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.78552 9.5 12.7855 14l9-4.5-9-4.5-8.99998 4.5Zm0 0V17m3-6v6.2222c0 .3483 2 1.7778 5.99998 1.7778 4 0 6-1.3738 6-1.7778V11"/>
                                                                        </svg>
                                                                    </span>
                                                                    @endif
                                                                    <img src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}" loading="lazy" class="rounded-circle" width="38" height="38">
                                                                </div>
                                                                <div class="comment-inner flex-grow-1">
                                                                    <h6 class="commenter mb-1">
                                                                        <a href="#" class="fw-semibold text-dark">{{ $reply->user->name }}</a>
                                                                    </h6>
                                                                    <div class="comment-meta small text-muted d-flex align-items-center gap-2">
                                                                        <span>{{ $reply->created_at->diffForHumans() }}</span>
                                                                        <span>•</span>
                                                                        <a class="text-decoration-none text-primary cursor-pointer" wire:click.prevent="showReplyForm({{ $reply->id }})">Reply</a>
                                                                    </div>
                                                                    <p class="mb-0 mt-1" wire:ignore>{!! $reply->content !!}</p>
                                                                    <livewire:client.shared.reaction-box :model="$reply" wire:key="reaction-comment-{{ $reply->id }}"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($replyingTo === $reply->id)
                                                            <livewire:client.lesson.components.comment.reply-create
                                                                :parentComment="$reply"
                                                                wire:key="reply-{{ $reply->id }}"
                                                            />
                                                        @endif

                                                        @if($reply->replies->count() > 0)
                                                            @if(empty($loadedReplies[$reply->id]))
                                                                <a
                                                                    class="rbt-btn-link d-inline-flex align-items-center gap-1"
                                                                    wire:click.prevent="loadReplies({{ $reply->id }})"
                                                                    wire:loading.attr="disabled"
                                                                    wire:target="loadReplies({{ $reply->id }})"
                                                                >
                                                                    <span wire:loading.remove wire:target="loadReplies({{ $reply->id }})">
                                                                        View {{ Str::plural($reply->replies_count . ' reply') }}
                                                                    </span>

                                                                    <span class="spinner-border spinner-border-sm text-primary"
                                                                          wire:loading
                                                                          wire:target="loadReplies({{ $reply->id }})"
                                                                          role="status"
                                                                          aria-hidden="true"></span>

                                                                    <span wire:loading wire:target="loadReplies({{ $reply->id }})">Loading...</span>
                                                                </a>
                                                            @else
                                                                <ul class="children">
                                                                    @foreach($loadedReplies[$reply->id] as $subReply)
                                                                        <x-client.comment.comment-item :comment="$subReply" :replyingTo="$replyingTo" wire:key="comment-{{ $subReply->id }}"/>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                </li>
                            @empty
                                <x-client.share-ui.empty-comment-animation/>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <livewire:client.lesson.components.comment.comment-create :$lesson/>
            </div>
        </div>
    </div>
</div>
