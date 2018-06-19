<!DOCTYPE html>
<!--suppress ALL -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>
<div id="top-nav">&nbsp;</div>
<div>
    <main id="main">
        @yield('content')
    </main>
    <div id="footer">
        <div id="footer-left">Parse Test</div>
        @yield('links')
        <div id="footer-right">Joseph Collier</div>
    </div>
</div>
</body>
</html>
