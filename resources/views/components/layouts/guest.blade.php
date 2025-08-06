<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Chess - Login' }}</title>

    <!-- Styles -->
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <!-- Require the Slide-over Pro component -->
    @livewire('slide-over-pro')
    @wireUiScripts
    @livewireScripts
</body>
</html>
