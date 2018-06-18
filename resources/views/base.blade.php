<!DOCTYPE html>
<!--suppress ALL -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="{{ asset('css/news.css') }}" rel="stylesheet">
</head>
<body>
<div>
    <main id="main">
        @yield('content')
    </main>
</div>
</body>
</html>
