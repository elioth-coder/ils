<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    {{ $head ?? '' }}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
    html, body {
        overflow: unset;
    }
    </style>
</head>

<body>
    {{ $slot }}
    {{ $script ?? '' }}
</body>
</html>
