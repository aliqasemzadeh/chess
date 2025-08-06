<div class="bg-gray-200 dark:bg-gray-900 shadow-md rounded-lg p-6">
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('Login') }} {{ __('to') }} Chess</h1>
        <p class="text-gray-600">{{ __('Enter your credentials to access your account') }}</p>
    </div>

    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login">
        <div class="mb-4">
            <x-input
                wire:model.blur="email"
                label="{{ __('Email') }}"
                placeholder="{{ __('Enter your email') }}"
                icon="user"
            />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <x-password
                wire:model.blur="password"
                label="{{ __('Password') }}"
                placeholder="{{ __('Enter your password') }}"
            />
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <input id="remember" type="checkbox" wire:model="remember" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="remember" class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
            </div>

            <a href="#" class="text-sm text-blue-600 hover:underline">{{ __('Forgot password?') }}</a>
        </div>

        <x-button
            type="submit"
            class="w-full justify-center"
            primary
            label="{{ __('Login') }}"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-70 cursor-wait"
        />

        <div wire:loading wire:target="login" class="mt-2 text-center text-sm text-gray-600">
            {{ __('Processing login...') }}
        </div>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
        {{ __("Don't have an account?") }}
        <a href="{{ route('register') }}" class="text-blue-600 hover:underline">{{ __('Register') }} {{ __('here') }}</a>
    </div>
</div>
