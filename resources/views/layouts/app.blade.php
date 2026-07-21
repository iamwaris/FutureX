<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ app(\App\Services\ThemeService::class)->googleFontsUrl() }}">
    <link rel="stylesheet" href="{{ route('theme.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text-primary font-body antialiased">
    @yield('content')
</body>
</html>
