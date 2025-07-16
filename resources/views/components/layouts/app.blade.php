<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow"/>
    <meta name="description" content="CodeZone is a platform for developers to learn, share, and grow their coding skills.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset("/images/favicon.ico") }}">

    @include('sweetalert2::index')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'CodeZone' }}</title>
</head>
<body class="rbt-header-sticky">
{{ $slot  }}
<script src="{{ asset('js/vendor/isotop.js') }}"></script>
<script src="{{ asset('js/vendor/imageloaded.js') }}"></script>
<script src="{{ asset('js/vendor/wow.js') }}"></script>
<script src="{{ asset('js/vendor/waypoint.min.js') }}"></script>
</body>
</html>
