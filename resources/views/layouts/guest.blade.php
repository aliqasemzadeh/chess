<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>{{ $title ?? __('Guest') }} - {{ config('app.name') }}</title>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <header>
    <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('images/logo.svg') }}" class="mr-3 h-6 sm:h-9" alt="{{ config('app.name') }}">
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ config('app.name') }}</span>
            </a>
            <div class="flex items-center lg:order-2">
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>
                <a href="{{ route('login') }}" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">{{ __('Login') }}</a>
            </div>
        </div>
    </nav>
</header>
    <!-- Main content -->
    <main>
        <section class="bg-gray-50 dark:bg-gray-900">
            <div class="mx-auto grid h-screen max-w-screen-xl px-4 py-8 lg:grid-cols-12 lg:gap-20 lg:py-16">
                <div class="w-full place-self-center lg:col-span-6">
                    <div class="mx-auto max-w-lg rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800 sm:p-6">
                        <a href="#" class="mb-4 inline-flex items-center text-xl font-semibold text-gray-900 dark:text-white sm:mb-6">
                            {{ $title ?? __('Register') }}
                        </a>
                        {{ $slot }}
                    </div>
                </div>
                <div class="ml-auto hidden place-self-center lg:col-span-6 lg:flex">
                    <img class="mx-auto dark:hidden" src="{{ asset('images/guest.svg') }}" alt="{{ __('illustration') }}" />
                    <img class="mx-auto hidden dark:flex" src="{{ asset('images/guest.svg') }}" alt="{{ __('illustration') }}" />
                </div>
            </div>
        </section>

    </main>


    @livewireScripts
</body>
</html>
