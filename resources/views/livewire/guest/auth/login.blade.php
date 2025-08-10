<div>
    <form>
        <x-input
            label="{{ __('Email') }}"
            placeholder="{{ __('Email') }}"
        />
        <x-password
            label="{{ __('Password') }}"
            placeholder="{{ __('Password') }}"
        />
        <x-button type="button" wire:click="login" class="w-full" label="{{ __('Login') }}" />
    </form>
</div>
