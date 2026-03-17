<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('includes.header')
    
    <main>
        @yield('content')
    </main>

    @include('includes.footer')
</body>
</html>