<div class="p-4 space-y-4">
    <x-card>
        <div class="space-y-4">
            <x-input label="نام" wire:model.defer="name" />
            <x-input label="ایمیل" wire:model.defer="email" />
            <x-input type="password" label="رمز عبور (اختیاری)" wire:model.defer="password" />
            <x-input type="password" label="تکرار رمز عبور" wire:model.defer="password_confirmation" />

            <div class="flex justify-end space-x-2 space-x-reverse">
                <x-button flat wire:click="$dispatch('slide-over.close')">انصراف</x-button>
                <x-button primary wire:click="save">ذخیره</x-button>
            </div>
        </div>
    </x-card>
</div>
