<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    @livewireStyles
    <title>{{ $title ?? 'Admin' }}</title>
    <script>
        // Theme init: run before content paint
        (function() {
            try {
                const saved = localStorage.getItem('color-theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = saved === 'dark' || (saved === 'system' && prefersDark) || (!saved && prefersDark);
                if (isDark) document.documentElement.classList.add('dark');
                else document.documentElement.classList.remove('dark');
            } catch (e) {}
        })();
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-slate-800 dark:text-slate-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar (RTL on right) -->
        <aside class="hidden md:block w-64 bg-white dark:bg-gray-800 border-l border-slate-200 dark:border-gray-700">
            <div class="h-16 flex items-center px-4 font-semibold">پنل مدیریت</div>
            <nav class="px-2 space-y-1">
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-gray-700">داشبورد</a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-gray-700">کاربران</a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-gray-700">تنظیمات</a>
            </nav>
        </aside>

        <!-- Main area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Topbar -->
            <header class="h-16 bg-white dark:bg-gray-800 border-b border-slate-200 dark:border-gray-700 flex items-center justify-between px-4">
                <div class="flex items-center gap-3">
                    <button class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-md hover:bg-slate-100 dark:hover:bg-gray-700" aria-label="Open sidebar">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 6h14M3 10h14M3 14h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </button>
                    <div class="font-medium">{{ $header ?? '' }}</div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <button id="theme-toggle-admin" type="button" class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm bg-slate-100 dark:bg-gray-700 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-gray-600" aria-haspopup="true" aria-expanded="false">تم</button>
                        <div id="theme-menu-admin" class="hidden absolute z-20 mt-2 w-40 rounded-md border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-lg">
                            <button data-theme-value="light" class="block w-full text-right px-3 py-2 text-sm hover:bg-slate-100 dark:hover:bg-gray-700">روشن</button>
                            <button data-theme-value="dark" class="block w-full text-right px-3 py-2 text-sm hover:bg-slate-100 dark:hover:bg-gray-700">تاریک</button>
                            <button data-theme-value="system" class="block w-full text-right px-3 py-2 text-sm hover:bg-slate-100 dark:hover:bg-gray-700">سیستم</button>
                        </div>
                    </div>
                    <span class="text-sm text-slate-500 dark:text-slate-300">مدیر</span>
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
    <script>
        // Theme toggle dropdown logic (simple, no dependency)
        (function(){
            const btn = document.getElementById('theme-toggle-admin');
            const menu = document.getElementById('theme-menu-admin');
            if (!btn || !menu) return;
            const apply = (mode) => {
                try {
                    localStorage.setItem('color-theme', mode);
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    const dark = mode === 'dark' || (mode === 'system' && prefersDark);
                    document.documentElement.classList.toggle('dark', dark);
                } catch(e) {}
            };
            btn.addEventListener('click', () => { menu.classList.toggle('hidden'); });
            menu.querySelectorAll('[data-theme-value]').forEach(el => {
                el.addEventListener('click', () => { apply(el.getAttribute('data-theme-value')); menu.classList.add('hidden'); });
            });
            document.addEventListener('click', (e) => { if (!menu.contains(e.target) && e.target !== btn) menu.classList.add('hidden'); });
        })();
    </script>
</body>
</html>
