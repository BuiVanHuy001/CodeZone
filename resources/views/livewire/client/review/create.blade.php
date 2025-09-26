<div class="comment-respond">
    <h4 class="title mt-3">Share Your Experience</h4>
    <p class="comment-notes">Your feedback helps others make informed decisions</p>

    <div class="row row--10">
        <form wire:submit.prevent="submitReview">
            @csrf
            <div class="col-12">
                <div class="rating-stars">
                    @for($i = $max; $i >= 1; $i--)
                        <input value="{{ $i }}" name="rating" id="star{{ $i }}" type="radio" wire:model="rating"/>
                        <label title="{{ $i }} stars" for="star{{ $i }}">
                            <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                 stroke="#000000" fill="none" viewBox="0 0 24 24"
                                 height="35" width="35" xmlns="http://www.w3.org/2000/svg"
                                 class="svgOne">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                            <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                 stroke="#000000" fill="none" viewBox="0 0 24 24"
                                 height="35" width="35" xmlns="http://www.w3.org/2000/svg"
                                 class="svgTwo">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                            <div class="ombre"></div>
                        </label>
                    @endfor
                </div>
                @error('rating') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12">
                <div class="form-group">
                    <textarea id="content" wire:model="content" rows="4" placeholder="Write your review"></textarea>
                </div>
                @error('content') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12">
                <button class="rbt-btn btn-gradient hover-icon-reverse" type="submit">
                    <span class="icon-reverse-wrapper">
                        <span class="btn-text">Submit Review</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@assets
<style>
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: start;
        gap: 0.3rem;
        transform-style: preserve-3d;
        perspective: 1000px;
    }

    .rating-stars input {
        display: none;
    }

    .rating-stars label {
        padding: 0 !important
    }

    .rating-stars label::before, .rating-stars label::after {
        display: none;
    }

    .rating-stars label .svgOne {
        stroke: #ccc;
        fill: rgba(255, 217, 0, 0);
        transition: stroke 0.5s ease,
        fill 0.5s ease;
    }

    .rating-stars label .svgTwo {
        position: absolute;
        top: -1px;
        fill: gold;
        stroke: rgba(255, 217, 0, 0);
        opacity: 0;
        transition: stroke 0.5s ease,
        fill 0.5s ease,
        opacity 0.5s ease;
    }

    .rating-stars label {
        position: relative;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 3px;
        transition: all 0.5s ease;
    }

    .rating-stars label:hover .svgOne,
    .rating-stars label:hover ~ label .svgOne {
        stroke: gold;
    }

    .rating-stars input:checked ~ label .svgOne {
        stroke: #cccccc00;
    }

    .rating-stars input:checked ~ label .svgTwo {
        transform: rotateX(0deg) rotateY(0deg) translateY(0px);
        opacity: 1;
        animation: displayStar 0.5s cubic-bezier(0.75, 0.41, 0.82, 1.2);
    }

    @keyframes displayStar {
        0% {
            transform: rotateX(100deg) rotateY(100deg) translateY(10px);
        }
        100% {
            transform: rotateX(0deg) rotateY(0deg) translateY(0px);
        }
    }

    .ombre {
        background: radial-gradient(
            ellipse closest-side,
            rgba(0, 0, 0, 0.24),
            rgba(0, 0, 0, 0)
        );
        width: 30px;
        height: 8px;
        opacity: 0;
        transition: opacity 0.6s ease 0.2s;
    }

    .rating-stars label:hover .ombre,
    .rating-stars label:hover ~ label .ombre {
        opacity: 0.3;
    }

    .rating-stars input:checked ~ label .ombre {
        opacity: 1;
    }

    .rating-stars label:hover .svgTwo:hover {
        animation: chackStar 0.6s ease-out,
        displayStar none 1s;
    }

    @keyframes chackStar {
        0% {
            transform: rotate(0deg);
        }
        20% {
            transform: rotate(-20deg);
        }
        50% {
            transform: rotate(20deg);
        }
        80% {
            transform: rotate(-20deg);
        }
        100% {
            transform: rotate(0deg);
        }
    }
</style>
@endassets
