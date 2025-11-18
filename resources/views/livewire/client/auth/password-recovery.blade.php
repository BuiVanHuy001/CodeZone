<div class="rbt-contact-form contact-form-style-1 max-width-auto mx-auto my-5 w-50">
    <h3 class="title text-center">Find your account</h3>
    @if($user)
        <div class="rbt-avatars m-auto">
            <img src="{{ $user->getAvatarPath() }}" alt="Author Images">
        </div>
        <h6 class="text-center">{{ $user->name }}</h6>
        <p>We will send you an email with your reset password.</p>
        <button wire:click="sendPasswordResetLink"
                class="rbt-btn w-50 mx-auto"
                wire:loading.attr="disabled"
                wire:target="sendPasswordResetLink">
            <span wire:loading.remove wire:target="sendPasswordResetLink">Continue</span>
            <span wire:loading wire:target="sendPasswordResetLink">Sending...</span>
        </button>
    @else
        <form class="max-width-auto" wire:submit="findAccount">
            <x-client.dashboard.inputs.text
                model="emailInput"
                label="Email address"
                type="email"
                name="emailInput"
                placeholder="Enter your email"
                info="Please enter your email address to search for your account."
            />

            <div class="d-flex justify-content-center mb-5">
                <button type="submit"
                        class="rbt-btn w-50 mx-auto"
                        wire:loading.attr="disabled"
                        wire:target="search">
                    <span wire:loading.remove wire:target="search">Find</span>
                    <span wire:loading wire:target="search">Searching...</span>
                </button>

            </div>
        </form>
        <div class="text-center mb-3">
            <p class="description">Don't have an account?
                <a class="rbt-btn-link" href="{{ route('student.register') }}"><strong>Register here</strong></a>
            </p>
        </div>
    @endif
</div>
