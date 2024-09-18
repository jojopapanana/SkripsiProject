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
        <x-navbar></x-navbar>
        <main class="max-vh-100 mt-5">
            {{ $slot }}
        </main>
        {{-- <x-footer></x-footer> --}}
    </div>
</body>
</html>
