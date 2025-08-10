<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>{{ $title ?? 'Guest' }}</title>
</head>
<body class="bg-gray-50 text-slate-800">
    <!-- Simple public header -->
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="font-semibold">Site</a>
            <nav class="flex items-center gap-4 text-sm">
                <a href="/login" class="text-slate-600 hover:text-slate-900">Login</a>
                <a href="/register" class="text-slate-600 hover:text-slate-900">Register</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Simple footer -->
    <footer class="mt-8 py-6 text-center text-sm text-slate-500">
        © {{ date('Y') }}. All rights reserved.
    </footer>

    @livewireScripts
</body>
</html>
