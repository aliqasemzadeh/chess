<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">بازی‌های من</h1>
                <p class="mt-2 text-sm text-gray-700">لیست بازی‌های شطرنج شما</p>
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
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">رنگ شما</th>
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
                                @php
                                    $playerColor = $game->getPlayerColor(auth()->user());
                                    $opponent = $playerColor === 'white' ? $game->blackPlayer : $game->whitePlayer;
                                @endphp
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ auth()->user()->name }} ({{ $playerColor === 'white' ? 'سفید' : 'سیاه' }})</span>
                                            <span class="text-gray-500">vs {{ $opponent->name }} ({{ $playerColor === 'white' ? 'سیاه' : 'سفید' }})</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $playerColor === 'white' ? 'bg-white text-black ring-1 ring-inset ring-gray-300' : 'bg-gray-900 text-white' }}">
                                            {{ $playerColor === 'white' ? 'سفید' : 'سیاه' }}
                                        </span>
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
                                                    <span class="text-green-600">{{ $playerColor === 'white' ? 'شما برنده شدید' : 'شما باختید' }}</span>
                                                    @break
                                                @case('black_win')
                                                    <span class="text-green-600">{{ $playerColor === 'black' ? 'شما برنده شدید' : 'شما باختید' }}</span>
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
                                        @if($game->status === 'active' || $game->status === 'pending')
                                            <x-button primary sm href="{{ route('user.games.play', $game->id) }}">
                                                <x-icon name="play" class="w-4 h-4 mr-2" />
                                                بازی
                                            </x-button>
                                        @else
                                            <x-button flat sm href="{{ route('user.games.play', $game->id) }}">
                                                <x-icon name="eye" class="w-4 h-4 mr-2" />
                                                مشاهده
                                            </x-button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-4 text-sm text-gray-500 text-center">هیچ بازی‌ای یافت نشد</td>
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
