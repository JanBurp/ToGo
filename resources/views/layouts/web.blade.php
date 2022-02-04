<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ToGo - @yield('title')</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>

    <body class="container">

        <div class="header">
            <h1><a href="/">ToGo</a> - @yield('title')</h1>
        </div>

        @yield('content')

    </body>
</html>
