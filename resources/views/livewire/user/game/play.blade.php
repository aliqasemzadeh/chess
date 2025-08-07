<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Game Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">بازی شطرنج</h1>
                    <p class="text-gray-600">
                        {{ $game->whitePlayer->name }} (سفید) vs {{ $game->blackPlayer->name }} (سیاه)
                    </p>
                </div>
                <div class="flex items-center space-x-4 space-x-reverse">
                    @if($game->status === 'pending' && auth()->user()->isAdmin())
                        <x-button primary wire:click="startGame">
                            شروع بازی
                        </x-button>
                    @endif
                    @if($game->status === 'active' && auth()->user()->isAdmin())
                        <x-button flat negative wire:click="endGame('draw')">
                            پایان مساوی
                        </x-button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Game Status -->
        <div class="mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-sm font-medium text-gray-500">وضعیت بازی</div>
                        <div class="mt-1">
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
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm font-medium text-gray-500">نوبت</div>
                        <div class="mt-1">
                            @if($game->status === 'active')
                                <span class="font-medium {{ $game->turn === 'white' ? 'text-white' : 'text-black' }}">
                                    {{ $game->turn === 'white' ? 'سفید' : 'سیاه' }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm font-medium text-gray-500">رنگ شما</div>
                        <div class="mt-1">
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $playerColor === 'white' ? 'bg-white text-black ring-1 ring-inset ring-gray-300' : 'bg-gray-900 text-white' }}">
                                {{ $playerColor === 'white' ? 'سفید' : 'سیاه' }}
                            </span>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm font-medium text-gray-500">زمان باقی‌مانده</div>
                        <div class="mt-1 text-lg font-mono">
                            @if($timeLeft)
                                {{ $timeLeft }}
                            @else
                                <span class="text-gray-400">نامحدود</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Game Board and Controls -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Chess Board -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">صفحه شطرنج</h3>
                    </div>
                    <div id="chessboard" class="mx-auto" style="width: 400px; height: 400px;"></div>
                    
                    @if($canMove)
                        <div class="mt-4 text-center">
                            <div class="bg-green-50 border border-green-200 rounded-md p-3">
                                <p class="text-green-800 font-medium">نوبت شماست!</p>
                                <p class="text-green-600 text-sm">می‌توانید حرکت کنید</p>
                            </div>
                        </div>
                    @elseif($game->status === 'active')
                        <div class="mt-4 text-center">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                                <p class="text-yellow-800 font-medium">نوبت حریف شماست</p>
                                <p class="text-yellow-600 text-sm">لطفاً منتظر بمانید</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Move History and Game Info -->
            <div class="space-y-6">
                <!-- Move History -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">تاریخچه حرکات</h3>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        @forelse($moves as $move)
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                <span class="text-sm font-medium">{{ $move['move_number'] }}.</span>
                                <span class="text-sm">{{ $move['san'] ?? $move['from_square'] . '-' . $move['to_square'] }}</span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm text-center">هنوز حرکتی انجام نشده</p>
                        @endforelse
                    </div>
                </div>

                <!-- Game Controls -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">کنترل‌های بازی</h3>
                    <div class="space-y-3">
                        <x-button full wire:click="$dispatch('refreshGame')">
                            <x-icon name="refresh" class="w-4 h-4 mr-2" />
                            بروزرسانی
                        </x-button>
                        
                        @if($game->status === 'active' && auth()->user()->isAdmin())
                            <x-button full flat negative wire:click="endGame('white_win')">
                                پایان - پیروزی سفید
                            </x-button>
                            <x-button full flat negative wire:click="endGame('black_win')">
                                پایان - پیروزی سیاه
                            </x-button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/chess.js@1.0.0-beta.6/dist/chess.js"></script>
    <script src="https://unpkg.com/cm-chessboard@8.7.8/dist/cm-chessboard.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/cm-chessboard@8.7.8/dist/cm-chessboard.css">
    
    <script>
        document.addEventListener('livewire:init', () => {
            let board;
            let chess;
            
            function initChessBoard() {
                const boardElement = document.getElementById('chessboard');
                if (!boardElement) return;
                
                // Initialize chess.js
                chess = new Chess('{{ $game->fen }}');
                
                // Initialize chessboard
                board = new Chessboard(boardElement, {
                    position: chess.fen(),
                    style: {
                        cssClass: 'default',
                        showCoordinates: true,
                    },
                    responsive: true,
                    orientation: '{{ $playerColor === "white" ? "white" : "black" }}',
                });
                
                // Handle move events
                board.on('move', (e) => {
                    const move = chess.move(e);
                    if (move) {
                        // Send move to Livewire
                        @this.makeMove(e.from, e.to);
                    } else {
                        // Invalid move, revert
                        board.setPosition(chess.fen());
                    }
                });
            }
            
            // Initialize board when component loads
            initChessBoard();
            
            // Listen for game updates
            Livewire.on('moveMade', () => {
                if (board && chess) {
                    chess = new Chess('{{ $game->fen }}');
                    board.setPosition(chess.fen());
                }
            });
            
            // Auto-refresh every 5 seconds for active games
            @if($game->status === 'active')
            setInterval(() => {
                @this.refreshGame();
            }, 5000);
            @endif
        });
    </script>
    @endpush
</div>
