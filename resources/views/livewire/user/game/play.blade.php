<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center justify-between">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">بازی شطرنج</h1>
                <p class="mt-2 text-sm text-gray-700">نمایش اطلاعات بازی و انجام حرکت</p>
            </div>
            <div class="text-sm text-gray-600">
                @if($game->status === 'active' && $timeLeft)
                    <span>زمان باقی‌مانده: {{ $timeLeft }}</span>
                @endif
            </div>
        </div>

        <!-- Players -->
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-card>
                <div class="text-center">
                    <div class="font-semibold">بازیکن سفید</div>
                    <div>{{ $game->whitePlayer->name }}</div>
                </div>
            </x-card>
            <x-card>
                <div class="text-center">
                    <div class="font-semibold">نوبت</div>
                    <div>
                        @if($game->status === 'active')
                            {{ $game->turn === 'white' ? 'سفید' : 'سیاه' }}
                        @else
                            -
                        @endif
                    </div>
                </div>
            </x-card>
            <x-card>
                <div class="text-center">
                    <div class="font-semibold">بازیکن سیاه</div>
                    <div>{{ $game->blackPlayer->name }}</div>
                </div>
            </x-card>
        </div>

        <!-- Board placeholder and controls -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <x-card>
                    <div class="aspect-square w-full bg-gray-100 flex items-center justify-center text-gray-400">
                        صفحه شطرنج (Placeholder)
                    </div>
                    <div class="mt-4 flex items-center space-x-2 space-x-reverse">
                        <x-input placeholder="از خانه (مثل e2)" wire:model.defer="from" />
                        <x-input placeholder="به خانه (مثل e4)" wire:model.defer="to" />
                        <x-button primary wire:click="makeMove($wire.from, $wire.to)" :disabled="!$canMove">انجام حرکت</x-button>
                    </div>
                    @if(!$canMove)
                        <div class="text-xs text-gray-500 mt-2">اکنون نوبت شما نیست یا بازی فعال نیست.</div>
                    @endif
                </x-card>
            </div>
            <div>
                <x-card>
                    <div class="font-semibold mb-2">تاریخچه حرکات</div>
                    <div class="max-h-80 overflow-y-auto">
                        <ol class="list-decimal list-inside space-y-1 text-sm">
                            @foreach($moves as $m)
                                <li>{{ $m['san'] ?? ($m['from_square'] . '-' . $m['to_square']) }}</li>
                            @endforeach
                        </ol>
                    </div>
                </x-card>

                <x-card class="mt-4">
                    <div class="space-y-2">
                        <div>وضعیت:
                            @switch($game->status)
                                @case('pending') در انتظار @break
                                @case('active') فعال @break
                                @case('completed') پایان یافته @break
                                @case('abandoned') رها شده @break
                            @endswitch
                        </div>
                        <div>شروع: {{ $game->start_at?->format('Y/m/d H:i') ?? '-' }}</div>
                        <div>پایان: {{ $game->end_at?->format('Y/m/d H:i') ?? '-' }}</div>
                        <div>FEN: <span class="font-mono text-xs break-all">{{ $game->fen }}</span></div>
                    </div>

                    @if(auth()->user()->isAdmin())
                        <div class="mt-4 flex items-center space-x-2 space-x-reverse">
                            <x-button primary wire:click="startGame">شروع بازی</x-button>
                            <x-button flat positive wire:click="endGame('white_win')">برد سفید</x-button>
                            <x-button flat negative wire:click="endGame('black_win')">برد سیاه</x-button>
                            <x-button flat wire:click="endGame('draw')">مساوی</x-button>
                        </div>
                    @endif
                </x-card>
            </div>
        </div>
    </div>
</div>
