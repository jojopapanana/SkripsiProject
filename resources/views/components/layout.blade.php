<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
        <!-- Favicon -->
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"> --}}
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

</head>
<body>
    <div class="d-flex flex-row" id="app">
        @unless (request()->routeIs('login') || request()->routeIs('register'))
            <x-navbar></x-navbar>
        @endunless
        <main class="max-vh-100 mt-5">
            {{ $slot }}
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    @stack('scripts')
</body>
</html>
