<x-base page-title="403 Forbidden">
    <div class="rbt-error-area bg-gradient-11 rbt-section-gap">
        <div class="error-area">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-10">
                        <h1 class="title">403!</h1>
                        <h3 class="sub-title">Forbidden</h3>
                        <p>Sorry, you do not have permission to access this page. If you believe this is an error,
                            please contact the administrator</p>
                        <a class="rbt-btn btn-gradient icon-hover" href="{{ route('page.home') }}">
                            <span class="btn-text">Back To Home</span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-base>
