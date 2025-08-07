<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">بازی‌های شطرنج</h1>
                <p class="mt-2 text-sm text-gray-700">لیست تمام بازی‌های شطرنج در سیستم</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <x-button primary wire:click="openCreateSlideOver">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    ایجاد بازی جدید
                </x-button>
            </div>
        </div>

        <!-- Filters -->
        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <x-input wire:model.live="search" placeholder="جستجو بر اساس نام بازیکن..." />
            </div>
            <div>
                <x-select wire:model.live="statusFilter" placeholder="فیلتر بر اساس وضعیت">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="pending">در انتظار</option>
                    <option value="active">فعال</option>
                    <option value="completed">پایان یافته</option>
                    <option value="abandoned">رها شده</option>
                </x-select>
            </div>
            <div>
                <x-select wire:model.live="perPage" placeholder="تعداد در صفحه">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </x-select>
            </div>
        </div>

        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-right text-sm font-semibold text-gray-900 sm:pl-0">بازیکنان</th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">وضعیت</th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">نوبت</th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">تاریخ شروع</th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">نتیجه</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">عملیات</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($games as $game)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $game->whitePlayer->name }} (سفید)</span>
                                            <span class="text-gray-500">{{ $game->blackPlayer->name }} (سیاه)</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @switch($game->status)
                                            @case('pending')
                                                <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">در انتظار</span>
                                                @break
                                            @case('active')
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/20">فعال</span>
                                                @break
                                            @case('completed')
                                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-800 ring-1 ring-inset ring-blue-600/20">پایان یافته</span>
                                                @break
                                            @case('abandoned')
                                                <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-800 ring-1 ring-inset ring-red-600/20">رها شده</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @if($game->status === 'active')
                                            <span class="font-medium {{ $game->turn === 'white' ? 'text-white' : 'text-black' }}">
                                                {{ $game->turn === 'white' ? 'سفید' : 'سیاه' }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $game->start_at?->format('Y/m/d H:i') ?? '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @if($game->result)
                                            @switch($game->result)
                                                @case('white_win')
                                                    <span class="text-green-600">پیروزی سفید</span>
                                                    @break
                                                @case('black_win')
                                                    <span class="text-green-600">پیروزی سیاه</span>
                                                    @break
                                                @case('draw')
                                                    <span class="text-gray-600">مساوی</span>
                                                    @break
                                            @endswitch
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <div class="flex items-center space-x-2 space-x-reverse">
                                            <x-button flat sm wire:click="openEditSlideOver({{ $game->id }})">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </x-button>
                                            <x-button flat sm negative wire:click="deleteGame({{ $game->id }})">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </x-button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-4 text-sm text-gray-500 text-center">هیچ بازی‌ای یافت نشد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-6">
            {{ $games->links() }}
        </div>
    </div>

    <livewire:admin.game.create />
    <livewire:admin.game.edit />
</div>
