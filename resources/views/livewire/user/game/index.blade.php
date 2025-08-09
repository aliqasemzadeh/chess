<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">بازی‌های من</h1>
                <p class="mt-2 text-sm text-gray-700">لیست بازی‌هایی که در آن‌ها شرکت دارید</p>
            </div>
        </div>

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
                                <th class="py-3.5 pl-4 pr-3 text-right text-sm font-semibold text-gray-900 sm:pl-0">بازیکنان</th>
                                <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">وضعیت</th>
                                <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">نوبت</th>
                                <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">شروع</th>
                                <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">عملیات</th>
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
                                            @case('pending')<span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">در انتظار</span>@break
                                            @case('active')<span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">فعال</span>@break
                                            @case('completed')<span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">پایان یافته</span>@break
                                            @case('abandoned')<span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">رها شده</span>@break
                                        @endswitch
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $game->status === 'active' ? ($game->turn === 'white' ? 'سفید' : 'سیاه') : '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $game->start_at?->format('Y/m/d H:i') ?? '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <a href="{{ route('user.games.play', ['id' => $game->id]) }}" class="text-primary-600 hover:underline">ورود به بازی</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-3 py-4 text-sm text-gray-500 text-center">هیچ بازی‌ای یافت نشد</td>
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
</div>
