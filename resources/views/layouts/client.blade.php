<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="robots" content="noindex, follow"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('swal::index')

    <title>@yield('title' ?? 'Codezone - Online Learning platform')</title>
</head>
<body class="rbt-header-sticky">
<x-client.header.index/>
@yield('content')
<x-client.footer/>
<div class="rbt-progress-parent">
    <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
    </svg>
</div>
</body>

<script src="{{ asset('js/vendor/wow.js') }}"></script>
</html>
