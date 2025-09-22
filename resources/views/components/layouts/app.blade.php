<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow"/>
    <meta name="description" content="CodeZone is a platform for developers to learn, share, and grow their coding skills.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset("/images/favicon.ico") }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('swal::index')
    <title>{{ $title ?? 'CodeZone' }}</title>
</head>
<body class="rbt-header-sticky">
{{ $slot  }}
<div class="rbt-progress-parent">
    <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
    </svg>
</div>
<script src="{{ asset('js/vendor/isotop.js') }}"></script>
<script src="{{ asset('js/vendor/imageloaded.js') }}"></script>
<script src="{{ asset('js/vendor/wow.js') }}"></script>
@stack('scripts')
</body>
</html>
