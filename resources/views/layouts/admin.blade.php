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
@yield('content')
</body>
</html>
