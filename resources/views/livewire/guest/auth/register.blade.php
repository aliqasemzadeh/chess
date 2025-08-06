<div class="bg-white shadow-md rounded-lg p-6">
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('Register') }} {{ __('to') }} Chess</h1>
        <p class="text-gray-600">{{ __('Create your account to start playing') }}</p>
    </div>

    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="register">
        <div class="mb-4">
            <x-input
                wire:model.blur="name"
                label="{{ __('Name') }}"
                placeholder="{{ __('Enter your name') }}"
                icon="user"
            />
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <x-input
                wire:model.blur="email"
                label="{{ __('Email') }}"
                placeholder="{{ __('Enter your email') }}"
                icon="envelope"
                type="email"
            />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <x-password
                wire:model.blur="password"
                label="{{ __('Password') }}"
                placeholder="{{ __('Enter your password') }}"
            />
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <x-password
                wire:model.blur="password_confirmation"
                label="{{ __('Confirm Password') }}"
                placeholder="{{ __('Confirm your password') }}"
            />
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <x-button
            type="submit"
            class="w-full justify-center"
            primary
            label="{{ __('Register') }}"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-70 cursor-wait"
        />

        <div wire:loading wire:target="register" class="mt-2 text-center text-sm text-gray-600">
            {{ __('Processing') }}...
        </div>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
        {{ __('Already have an account?') }}
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">{{ __('Login') }} {{ __('here') }}</a>
    </div>
</div>
