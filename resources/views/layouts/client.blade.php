<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CodeZone - Online Courses & Education Platform</title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#ffffff">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick-theme.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/sal.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/feather.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/fontawesome.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/euclid-circulara.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/odometer.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animation.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-select.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery-ui.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/magnigy-popup.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/plyr.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jodit.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }} ">
</head>

<body class="rbt-header-sticky">
<x-client.switchmode/>
<x-client.header />

<x-client.mobilemenu/>

@yield('content')

<x-client.footer />

<div class="rbt-progress-parent">
    <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>

<script src="{{ asset('assets/js/vendor/modernizr.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery.js') }}"></script>
<script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/sal.js') }}"></script>
<script src="{{ asset('assets/js/vendor/js.cookie.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery.style.switcher.js') }}"></script>
<script src="{{ asset('assets/js/vendor/swiper.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-appear.js') }}"></script>
<script src="{{ asset('assets/js/vendor/odometer.js') }}"></script>
<script src="{{ asset('assets/js/vendor/isotop.js') }}"></script>
<script src="{{ asset('assets/js/vendor/imageloaded.js') }}"></script>
<script src="{{ asset('assets/js/vendor/wow.js') }}"></script>
<script src="{{ asset('assets/js/vendor/waypoint.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/easypie.js') }}"></script>
<script src="{{ asset('assets/js/vendor/text-type.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-one-page-nav.js') }}"></script>
<script src="{{ asset('assets/js/vendor/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/vendor/magnify-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/paralax-scroll.js') }}"></script>
<script src="{{ asset('assets/js/vendor/paralax.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/countdown.js') }}"></script>
<script src="{{ asset('assets/js/vendor/plyr.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jodit.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/Sortable.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
