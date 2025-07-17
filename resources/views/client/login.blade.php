<x-base page-title="Login">
    <div class="rbt-contact-form contact-form-style-1 max-width-auto mx-auto my-5 w-50">
        <h3 class="title text-center">Login</h3>
        <form class="max-width-auto" action="{{ route('client.login') }}" method="POST">
            @csrf
            <div @class(['form-group', 'focused' => old('email')])>
                <input name="email" type="text" value="{{ request('email') ?? old('email') }}"
                    @class(['border-danger' => $errors->has('email')]) />
                <label>Email address *</label>
                <span class="focus-border"></span>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input name="password" type="password">
                <label>Password *</label>
                <span class="focus-border"></span>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="row mb--30">
                <div class="col-lg-6">
                    <div class="rbt-checkbox">
                        <input type="checkbox" id="rememberme" name="rememberme">
                        <label for="rememberme">Remember me</label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="rbt-lost-password text-end">
                        <a class="rbt-btn-link" href="#">Lost your password?</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mb-5">
                <button class="rbt-btn w-50 mx-auto">Login</button>
            </div>
        </form>

        <div class="text-center mb-3">
            <p class="description">Don't have an account? <a class="rbt-btn-link"
                    href="{{ route('client.register') }}"><strong>Register here</strong></a></p>
        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-center mb-3">
                <span class="rbt-badge">Or login by</span>
            </div>

            <div class="d-flex justify-content-center gap-3 mb-3">
                <a href="{{ route('socialite.redirect', 'google') }}" class="rbt-badge-2">
                    <div class="d-inline-flex justify-content-between align-items-center gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Google
                    </div>
                </a>

                <a href="{{ route('socialite.redirect', 'facebook') }}" class="rbt-badge-2">
                    <div class="d-inline-flex justify-content-between align-items-center gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24">
                            <path fill="#1877F2"
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        Facebook
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-base>
