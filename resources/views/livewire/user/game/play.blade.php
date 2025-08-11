<div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-4 dark:text-white">{{ __('بازی شطرنج') }}</h2>
                <div x-data="chessPlay({
                        initialFen: @js($fen),
                        gameId: @js($game->id),
                        authUserId: @js(auth()->id()),
                        whiteUserId: @js($game->white_user_id),
                        blackUserId: @js($game->black_user_id),
                        currentTurn: @js($game->turn)
                    })"
                     x-init="init()"
                     class="flex flex-col items-center">

                    <div id="board" class="mb-4 w-full max-w-[480px] aspect-square" wire:ignore></div>

                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-700 dark:text-gray-300">FEN:</span>
                        <span class="text-xs font-mono px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-gray-800 dark:text-gray-100" x-text="fen"></span>
                    </div>

                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-300" x-show="error" x-text="error"></div>

                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        <span x-text="'Turn: ' + (currentTurn === 'white' ? 'White' : 'Black')"></span>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <h3 class="text-md font-semibold mb-3 dark:text-white">{{ __('حرکت‌ها') }}</h3>
                <ol class="list-decimal list-inside space-y-1 max-h-[480px] overflow-auto" id="moveList">
                    @foreach($game->moves as $move)
                        <li class="text-sm text-gray-800 dark:text-gray-100" wire:key="move-{{ $move->id }}">
                            <span class="font-medium">#{{ $move->move_number }}</span>
                            <span class="px-1 text-xs rounded bg-gray-100 dark:bg-gray-700">
                                {{ $move->user_id === $game->white_user_id ? __('White') : __('Black') }}
                            </span>
                            <span class="ml-1">{{ $move->san }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>


