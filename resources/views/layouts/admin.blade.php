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
    <link rel="stylesheet" href="{{ Vite::asset('resources/assets/admin/libs/sweetalert2/sweetalert2.min.css') }}">

    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])

</head>
<body>
@yield('content')

<script src="{{ Vite::asset('resources/assets/admin/libs/sweetalert2/sweetalert2.min.js') }}"></script>
</body>
</html>
