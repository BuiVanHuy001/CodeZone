<!DOCTYPE html>
<html
    lang="en"
    data-layout="vertical"
    data-topbar="light"
    data-sidebar="dark"
    data-sidebar-size="lg"
    data-sidebar-image="none"
    data-preloader="disable"
>
<head>
    <meta charset="utf-8"/>
    <title>Codezone admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}">
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
    @include('swal::index')
    @stack('styles')
</head>
<body>
<div id="layout-wrapper">
    @persist('header-banner')
    <x-admin.base.header/>
    <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endpersist

    <x-admin.base.sidebar/>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                {{ $slot }}
            </div>
        </div>
        <x-admin.base.footer/>
    </div>

    <button
        onclick="function topFunction() {
            document.body.scrollTop = 0, document.documentElement.scrollTop = 0
        }
        topFunction()"
        class="btn btn-danger btn-icon"
        id="back-to-top"
    >
        <i class="ri-arrow-up-line"></i>
    </button>
</div>
@stack('scripts')
<script src="{{ Vite::asset('resources/assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
</body>
</html>
