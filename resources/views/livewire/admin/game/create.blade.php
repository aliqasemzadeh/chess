<div class="p-4 space-y-4">
    <x-card>
        <div class="space-y-4">
            <x-select label="بازیکن سفید" wire:model.defer="white_player_id">
                <option value="">انتخاب کنید</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </x-select>

            <x-select label="بازیکن سیاه" wire:model.defer="black_player_id">
                <option value="">انتخاب کنید</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </x-select>

            <x-select label="وضعیت" wire:model.defer="status">
                <option value="pending">در انتظار</option>
                <option value="active">فعال</option>
                <option value="completed">پایان یافته</option>
                <option value="abandoned">رها شده</option>
            </x-select>

            <x-input type="datetime-local" label="زمان شروع" wire:model.defer="start_at" />
            <x-input type="datetime-local" label="زمان پایان" wire:model.defer="end_at" />

            <div class="flex justify-end space-x-2 space-x-reverse">
                <x-button flat wire:click="$dispatch('slide-over.close')">انصراف</x-button>
                <x-button primary wire:click="save">ذخیره</x-button>
            </div>
        </div>
    </x-card>
</div>
