<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>@yield('title')</title>
    <meta name="robots" content="noindex, follow"/>
    <meta name="description" content="Nền tảng học trực tuyến hàng đầu với các khóa học chất lượng cao">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset("/images/favicon.ico") }}">
    @include('sweetalert2::index')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="rbt-header-sticky">
@yield('content')
</body>
{{--<script src="{{ asset('js/vendor/isotop.js') }}"></script>--}}
{{--<script src="{{ asset('js/vendor/imageloaded.js') }}"></script>--}}
{{--<script src="{{ asset('js/vendor/wow.js') }}"></script>--}}
{{--<script src="{{ asset('js/vendor/waypoint.min.js') }}"></script>--}}
</html>
