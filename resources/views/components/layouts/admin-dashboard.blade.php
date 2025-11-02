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
    <meta
        content="Premium Multipurpose Admin & Dashboard Template"
        name="description"
    />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}">
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
</head>
<body>
<div id="layout-wrapper">
    <x-admin.base.header/>

    <x-admin.base.sidebar/>

    <div class="vertical-overlay"></div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                {{ $slot }}
            </div>
        </div>
        <x-admin.base.footer/>
    </div>

    <button
        onclick="topFunction()"
        class="btn btn-danger btn-icon"
        id="back-to-top"
    >
        <i class="ri-arrow-up-line"></i>
    </button>

    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>

@stack('scripts')
</body>
</html>
