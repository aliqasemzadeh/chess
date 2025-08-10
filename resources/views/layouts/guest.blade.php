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
    <title>{{ $title ?? 'Guest' }}</title>
    <script>
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
<body class="bg-gray-50 dark:bg-gray-900 text-slate-800 dark:text-slate-100 min-h-screen">
    <header class="bg-white dark:bg-gray-800 border-b border-slate-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="font-semibold">سایت</a>
            <div class="flex items-center gap-3">
                <nav class="hidden sm:flex items-center gap-4 text-sm">
                    <a href="/login" class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white">ورود</a>
                    <a href="/register" class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white">ثبت نام</a>
                </nav>
                <div class="relative">
                    <button id="theme-toggle-guest" type="button" class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm bg-slate-100 dark:bg-gray-700 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-gray-600">تم</button>
                    <div id="theme-menu-guest" class="hidden absolute z-20 mt-2 w-40 rounded-md border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-lg">
                        <button data-theme-value="light" class="block w-full text-right px-3 py-2 text-sm hover:bg-slate-100 dark:hover:bg-gray-700">روشن</button>
                        <button data-theme-value="dark" class="block w-full text-right px-3 py-2 text-sm hover:bg-slate-100 dark:hover:bg-gray-700">تاریک</button>
                        <button data-theme-value="system" class="block w-full text-right px-3 py-2 text-sm hover:bg-slate-100 dark:hover:bg-gray-700">سیستم</button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Flowbite-like default login page wrapper -->
    <main class="flex items-center justify-center py-8 sm:py-12">
        <div class="w-full max-w-md p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg border border-slate-200 dark:border-gray-700 shadow">
            {{ $slot }}
        </div>
    </main>

    <footer class="mt-auto py-6 text-center text-sm text-slate-500 dark:text-slate-400">
        © {{ date('Y') }}. همه حقوق محفوظ است.
    </footer>

    @livewireScripts
    <script>
        (function(){
            const btn = document.getElementById('theme-toggle-guest');
            const menu = document.getElementById('theme-menu-guest');
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
