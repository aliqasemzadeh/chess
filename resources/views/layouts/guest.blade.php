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
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-slate-800 dark:text-slate-100 min-h-screen">
<x-notifications position="bottom-end" />
<header class="bg-gray-900 pattern">
    <div class="container px-6 mx-auto">
        <nav class="flex py-6 flex-row justify-between items-center">
            <a href="#">
                @includeIf('logo')
                54555
            </a>

            <div class="flex items-center mt-2 -mx-2 sm:mt-0">
                <button id="theme-toggle" type="button"
                        class="justify-center w-100 inline-flex text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </nav>

    </div>
</header>
<div class="flex mt-8 justify-center lg:mt-0">
    <div class="w-full h-full max-w-md bg-white rounded-lg dark:bg-gray-800">
        <div class="px-6 py-8 text-center">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-white"></h2>
            <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

@wireUiScripts
@livewireScripts
</body>
</html>
