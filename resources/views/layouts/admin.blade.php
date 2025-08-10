<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>{{ $title ?? 'Admin' }}</title>
</head>
<body class="bg-gray-50 text-slate-800">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="hidden md:block w-64 bg-white border-r border-slate-200">
            <div class="h-16 flex items-center px-4 font-semibold">Admin Panel</div>
            <nav class="px-2 space-y-1">
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100 text-slate-700">Dashboard</a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100 text-slate-700">Users</a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100 text-slate-700">Settings</a>
            </nav>
        </aside>

        <!-- Main area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4">
                <div class="flex items-center gap-3">
                    <button class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-md hover:bg-slate-100" aria-label="Open sidebar">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 6h14M3 10h14M3 14h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </button>
                    <div class="font-medium">{{ $header ?? '' }}</div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-slate-500">Admin</span>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto">
                <div class="p-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
