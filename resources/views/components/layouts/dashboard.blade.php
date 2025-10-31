<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow"/>
    <meta name="description" content="CodeZone is a platform for developers to learn, share, and grow their coding skills.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset("/images/favicon.ico") }}">
    @vite(['resources/css/client/app.css', 'resources/js/client/app.js'])
    @include('swal::index')
    <title>{{ $title ?? 'CodeZone' }}</title>
</head>
<body class="rbt-header-sticky">
@persist('header-banner')
<x-client.header.index/>
<div class="rbt-page-banner-wrapper">
    <div class="rbt-banner-image"></div>
</div>
@endpersist
<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @persist('banner-top')
                <x-client.dashboard.banner-top/>
                @endpersist
                <div class="row g-5">
                    <div class="col-lg-3">
                        <x-client.dashboard.sidebar/>
                    </div>
                    <div class="col-lg-9">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rbt-separator-mid" wire:ignore>
    <div class="container">
        <hr class="rbt-separator m-0">
    </div>
</div>
<x-client.footer wire:ignore/>
<div class="rbt-progress-parent" wire:ignore>
    <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
    </svg>
</div>
@stack('scripts')
<script src="{{ asset('js/vendor/isotop.js') }}"></script>
<script src="{{ asset('js/vendor/imageloaded.js') }}"></script>
<script src="{{ asset('js/vendor/wow.js') }}"></script>
<script src="{{ asset('js/vendor/waypoint.min.js') }}"></script>
</body>
</html>
