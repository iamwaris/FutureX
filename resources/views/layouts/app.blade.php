<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>

    {{-- Applied before first paint so switching modes never flashes the wrong theme. --}}
    <script>
        (function () {
            var stored = localStorage.getItem('creatoros-theme');
            var isLight = stored === 'light';
            document.documentElement.classList.toggle('dark', !isLight);
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ app(\App\Services\ThemeService::class)->googleFontsUrl() }}">
    <link rel="stylesheet" href="{{ route('theme.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text-primary font-body antialiased">
    @include('partials.nav')

    @yield('content')

    @include('partials.footer')
</body>
</html>
