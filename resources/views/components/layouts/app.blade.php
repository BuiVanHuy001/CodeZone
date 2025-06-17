<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow"/>
    <meta name="description" content="Nền tảng học trực tuyến hàng đầu với các khóa học chất lượng cao">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset("/images/favicon.ico") }}">

    @include('sweetalert2::index')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Page Title' }}</title>
</head>
<body class="rbt-header-sticky">
@persist('header')
<x-header />
<div class="rbt-page-banner-wrapper">
    <div class="rbt-banner-image"></div>
</div>
@endpersist
<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @persist('dashboard.banner-top')
                <x-dashboard.banner-top/>
                @endpersist
                <div class="row g-5">
                    <div class="col-lg-3">
                        <livewire:client.sidebar wire:scroll/>
                    </div>

                    <div class="col-lg-9">
                        {{ $slot }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="rbt-separator-mid">
    <div class="container">
        <hr class="rbt-separator m-0">
    </div>
</div>

@persist('footer')
<x-footer/>
@endpersist

</body>
</html>
