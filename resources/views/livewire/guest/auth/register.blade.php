<section class="bg-gray-50 dark:bg-gray-900">
  <div class="mx-auto grid h-screen max-w-screen-xl px-4 py-8 lg:grid-cols-12 lg:gap-20 lg:py-16">
    <div class="w-full place-self-center lg:col-span-6">
      <div class="mx-auto max-w-lg rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800 sm:p-6">
        <a href="#" class="mb-4 inline-flex items-center text-xl font-semibold text-gray-900 dark:text-white sm:mb-6">
          <img class="ml-2 h-8 w-8" src="/images/logo.svg" alt="logo" />
          Flowbite
        </a>
        <h1 class="mb-2 text-2xl font-extrabold leading-tight tracking-tight text-gray-900 dark:text-white">{{ __('Create an account') }}</h1>
        <p class=" text-gray-500 dark:text-gray-400">{{ __('Already have an account?') }} <a class="font-medium text-primary-700 hover:underline dark:text-primary-500" href="{{ route('login') }}">{{ __('Sign in') }}</a></p>
        <form class="mt-4 space-y-4 sm:mt-6 sm:space-y-6" wire:submit="register">
          <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <div class="sm:col-span-2">
              <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ __('Full Name') }}</label>
              <input 
                type="text" 
                id="name" 
                wire:model="name" 
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 sm:text-sm @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" 
                placeholder="{{ __('Example: John Doe') }}" 
                required 
              />
              @error('name')
                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ __('Email') }}</label>
              <input 
                type="email" 
                id="email" 
                wire:model="email" 
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 sm:text-sm @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" 
                placeholder="name@company.com" 
                required 
              />
              @error('email')
                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ __('Password') }}</label>
              <input 
                type="password" 
                id="password" 
                wire:model="password" 
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 sm:text-sm @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" 
                placeholder="••••••••" 
                required 
              />
              @error('password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ __('Confirm Password') }}</label>
              <input 
                type="password" 
                id="password_confirmation" 
                wire:model="password_confirmation" 
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 sm:text-sm @error('password_confirmation') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" 
                placeholder="••••••••" 
                required 
              />
              @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="flex items-start">
            <div class="flex h-5 items-center">
              <input 
                id="terms" 
                type="checkbox" 
                wire:model="terms"
                class="focus:ring-3 h-4 w-4 rounded-sm border border-gray-300 bg-gray-50 focus:ring-primary-300 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600 @error('terms') border-red-500 focus:ring-red-500 @enderror" 
                required 
              />
            </div>
            <label for="terms" class="mr-3 text-sm text-gray-500 dark:text-gray-300">{{ __('I agree to the terms and conditions') }}</label>
          </div>
          @error('terms')
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
          @enderror

          <button 
            type="submit" 
            wire:loading.attr="disabled"
            class="w-full rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span wire:loading.remove>{{ __('Create account') }}</span>
            <span wire:loading>{{ __('Creating account...') }}</span>
          </button>
        </form>
      </div>
    </div>
    <div class="ml-auto hidden place-self-center lg:col-span-6 lg:flex">
      <img class="mx-auto dark:hidden" src="/images/sign-in.svg" alt="illustration" />
      <img class="mx-auto hidden dark:flex" src="/images/sign-in-dark.svg" alt="illustration" />
    </div>
  </div>
</section>
