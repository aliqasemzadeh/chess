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
                        blackUserId: @js($game->black_user_id)
                    })"
                     x-init="init()"
                     class="flex flex-col items-center">

                    <div id="board" class="mb-4" wire:ignore></div>

                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-700 dark:text-gray-300">FEN:</span>
                        <span class="text-xs font-mono px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-gray-800 dark:text-gray-100" x-text="fen"></span>
                    </div>

                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-300" x-show="error" x-text="error"></div>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <h3 class="text-md font-semibold mb-3 dark:text-white">{{ __('حرکت‌ها') }}</h3>
                <ol class="list-decimal list-inside space-y-1 max-h-[480px] overflow-auto" id="moveList"></ol>
            </div>
        </div>
    </div>

    <script>
        function chessPlay({ initialFen, gameId, authUserId, whiteUserId, blackUserId }) {
            return {
                fen: initialFen,
                board: null,
                game: null,
                error: '',
                colorForUser(userId) {
                    return userId === whiteUserId ? 'white' : (userId === blackUserId ? 'black' : null);
                },
                isUsersTurn() {
                    const turn = this.game.turn(); // 'w' or 'b'
                    const userColor = this.colorForUser(authUserId);
                    return (turn === 'w' && userColor === 'white') || (turn === 'b' && userColor === 'black');
                },
                init() {
                    this.game = new Chess(this.fen);

                    const cfg = {
                        position: this.fen,
                        draggable: true,
                        pieceTheme: 'https://chessboardjs.com/img/chesspieces/wikipedia/{piece}.png',
                        onDragStart: (source, piece) => {
                            this.error = '';
                            // Prevent moving opponent pieces or when game over
                            if (this.game.game_over() || !this.isUsersTurn()) return false;
                            if ((this.game.turn() === 'w' && piece.search(/^b/) !== -1) ||
                                (this.game.turn() === 'b' && piece.search(/^w/) !== -1)) {
                                return false;
                            }
                        },
                        onDrop: (source, target) => {
                            // Try move with chess.js
                            const move = this.game.move({ from: source, to: target, promotion: 'q' });
                            if (move === null) {
                                this.error = '{{ __('حرکت نامعتبر است') }}';
                                return 'snapback';
                            }

                            // Valid move: update board and FEN
                            const fenBefore = this.fen;
                            this.fen = this.game.fen();

                            // Update move list (UI only)
                            const li = document.createElement('li');
                            li.textContent = move.san;
                            document.getElementById('moveList').appendChild(li);

                            // Persist via Livewire
                            const payload = {
                                from: source,
                                to: target,
                                san: move.san,
                                fen_before: fenBefore,
                                fen_after: this.fen,
                                meta: { check: this.game.in_check(), checkmate: this.game.in_checkmate(), draw: this.game.in_draw() }
                            };

                            // Call Livewire saveMove
                            $wire.saveMove(payload);
                        },
                        onSnapEnd: () => {
                            this.board.position(this.fen);
                        }
                    };

                    this.board = Chessboard('board', cfg);

                    // Subscribe to broadcast updates for this game
                    if (window.Echo) {
                        window.Echo.private('game.' + gameId)
                            .listen('.game.move', (e) => {
                                // Another player's move: update local board/FEN
                                if (e && e.fen) {
                                    this.fen = e.fen;
                                    this.game.load(e.fen);
                                    this.board.position(e.fen, true);
                                    // Append move if present
                                    if (e.move && e.move.san) {
                                        const li = document.createElement('li');
                                        li.textContent = e.move.san;
                                        document.getElementById('moveList').appendChild(li);
                                    }
                                }
                            });
                    }

                    // Listen to Livewire browser event to sync local state when I move
                    window.addEventListener('move-saved', (event) => {
                        if (event && event.detail && event.detail.fen) {
                            this.fen = event.detail.fen;
                            this.game.load(this.fen);
                            this.board.position(this.fen, true);
                        }
                    });
                },
            }
        }
    </script>
</div>
