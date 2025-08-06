<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @livewireStyles
</head>
<body>
{{ $slot }}

<!-- Require the Slide-over Pro component -->
@livewire('slide-over-pro')
@wireUiScripts
@livewireScripts
</body>
</html>
