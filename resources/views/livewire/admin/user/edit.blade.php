<x-wire-elements-pro::tailwind.slide-over on-submit="save">
    <x-slot name="title">ویرایش کاربر: {{ $user->name }}</x-slot>

    <div class="space-y-6">
        <!-- Name Field -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                نام کاربر
            </label>
            <input 
                type="text" 
                id="name" 
                wire:model="name" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"
                placeholder="نام کاربر را وارد کنید"
            >
            @error('name') 
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                ایمیل
            </label>
            <input 
                type="email" 
                id="email" 
                wire:model="email" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"
                placeholder="ایمیل را وارد کنید"
            >
            @error('email') 
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                رمز عبور جدید (اختیاری)
            </label>
            <input 
                type="password" 
                id="password" 
                wire:model="password" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"
                placeholder="رمز عبور جدید را وارد کنید (اختیاری)"
            >
            @error('password') 
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Confirmation Field -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                تکرار رمز عبور جدید
            </label>
            <input 
                type="password" 
                id="password_confirmation" 
                wire:model="password_confirmation" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"
                placeholder="رمز عبور جدید را تکرار کنید"
            >
        </div>

        <!-- User Info -->
        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اطلاعات کاربر</h4>
            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                <p><strong>تاریخ عضویت:</strong> {{ $user->created_at->format('Y/m/d H:i') }}</p>
                <p><strong>آخرین بروزرسانی:</strong> {{ $user->updated_at->format('Y/m/d H:i') }}</p>
            </div>
        </div>
    </div>

    <x-slot name="buttons">
        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            بروزرسانی کاربر
        </button>
        <button type="button" wire:click="$dispatch('slide-over.close')" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            انصراف
        </button>
    </x-slot>
</x-wire-elements-pro::tailwind.slide-over>
