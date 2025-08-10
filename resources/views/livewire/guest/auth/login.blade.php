<x-card title="Lorem Ipsum is simply!">
    <form wire:submit.prevent="login" class="space-y-6">
        <x-bladewind::input label="{{ __('Email') }}" wire:model="email"  />
        <x-bladewind::input type="password" label="{{ __('Password') }}" wire:model="password"  />
        <x-bladewind::button type="submit" class="w-full">{{ __('Login') }}</x-bladewind::button>
    </form>
</x-card>
