<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{ $head ?? '' }}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
    html, body {
        overflow: unset;
        overflow-x: hidden;
    }
    </style>
</head>

<body>
    {{ $slot }}
    {{ $script ?? '' }}
</body>
</html>
