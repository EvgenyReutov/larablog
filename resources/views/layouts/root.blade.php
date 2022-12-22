<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @section('meta')
        <meta name="keywords" content="{{ config('app.name') }}">
        <meta name="description" content="{{ config('app.name') }}">
    @show


    <title>@yield('title', config('app.name'))</title>
    @yield('head-end')
<!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
@yield('body')

@yield('body-end')
</body>
</html>
