<x-wire-elements-pro::tailwind.slide-over>
    <x-slot name="title">
        ویرایش بازی
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
                @error('white_player_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="black_player_id" value="بازیکن سیاه" />
                <x-select wire:model="black_player_id" id="black_player_id" class="mt-1 block w-full">
                    <option value="">انتخاب کنید</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </x-select>
                @error('black_player_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="status" value="وضعیت بازی" />
                <x-select wire:model="status" id="status" class="mt-1 block w-full">
                    <option value="pending">در انتظار</option>
                    <option value="active">فعال</option>
                    <option value="completed">پایان یافته</option>
                    <option value="abandoned">رها شده</option>
                </x-select>
                @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="result" value="نتیجه بازی" />
                <x-select wire:model="result" id="result" class="mt-1 block w-full">
                    <option value="">بدون نتیجه</option>
                    <option value="white_win">پیروزی سفید</option>
                    <option value="black_win">پیروزی سیاه</option>
                    <option value="draw">مساوی</option>
                </x-select>
                @error('result')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="start_at" value="تاریخ شروع" />
                <x-input wire:model="start_at" type="datetime-local" id="start_at" class="mt-1 block w-full" />
                @error('start_at')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="end_at" value="تاریخ پایان" />
                <x-input wire:model="end_at" type="datetime-local" id="end_at" class="mt-1 block w-full" />
                @error('end_at')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3 space-x-reverse">
                <x-button flat wire:click="$dispatch('slide-over.close')">
                    انصراف
                </x-button>
                <x-button type="submit" primary>
                    بروزرسانی بازی
                </x-button>
            </div>
        </form>
    </x-slot>
</x-wire-elements-pro::tailwind.slide-over>
