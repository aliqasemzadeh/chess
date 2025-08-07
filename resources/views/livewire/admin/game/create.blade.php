<x-slide-over>
    <x-slot name="title">
        ایجاد بازی جدید
    </x-slot>

    <x-slot name="content">
        <form wire:submit="save" class="space-y-6">
            <div>
                <x-label for="white_player_id" value="بازیکن سفید" />
                <x-select wire:model="white_player_id" id="white_player_id" class="mt-1 block w-full">
                    <option value="">انتخاب کنید</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </x-select>
                <x-input-error for="white_player_id" class="mt-2" />
            </div>

            <div>
                <x-label for="black_player_id" value="بازیکن سیاه" />
                <x-select wire:model="black_player_id" id="black_player_id" class="mt-1 block w-full">
                    <option value="">انتخاب کنید</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </x-select>
                <x-input-error for="black_player_id" class="mt-2" />
            </div>

            <div>
                <x-label for="status" value="وضعیت بازی" />
                <x-select wire:model="status" id="status" class="mt-1 block w-full">
                    <option value="pending">در انتظار</option>
                    <option value="active">فعال</option>
                    <option value="completed">پایان یافته</option>
                    <option value="abandoned">رها شده</option>
                </x-select>
                <x-input-error for="status" class="mt-2" />
            </div>

            <div>
                <x-label for="start_at" value="تاریخ شروع" />
                <x-input wire:model="start_at" type="datetime-local" id="start_at" class="mt-1 block w-full" />
                <x-input-error for="start_at" class="mt-2" />
            </div>

            <div>
                <x-label for="end_at" value="تاریخ پایان" />
                <x-input wire:model="end_at" type="datetime-local" id="end_at" class="mt-1 block w-full" />
                <x-input-error for="end_at" class="mt-2" />
            </div>

            <div class="flex justify-end space-x-3 space-x-reverse">
                <x-button flat wire:click="$dispatch('slide-over.close')">
                    انصراف
                </x-button>
                <x-button type="submit" primary>
                    ایجاد بازی
                </x-button>
            </div>
        </form>
    </x-slot>
</x-slide-over>
