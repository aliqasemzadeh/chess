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

                    <div id="board" class="mb-4 w-full max-w-[480px] aspect-square" wire:ignore></div>

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
                    // chess.js provided via window.Chess from app.js
                    this.game = new Chess(this.fen);

                    // cm-chessboard provided via window.CmChessboard from app.js
                    const { Chessboard, COLOR, INPUT_EVENT_TYPE } = window.CmChessboard || {};

                    const el = document.getElementById('board');

                    this.board = new Chessboard(el, {
                        position: this.fen,
                        assetsUrl: 'https://shaack.com/projekte/cm-chessboard/assets/',
                        sprite: {
                            url: 'https://shaack.com/projekte/cm-chessboard/assets/images/chessboard-sprite-staunty.svg'
                        },
                        style: { cssClass: 'cm-default', showCoordinates: true }
                    });

                    // Enable move input and validate with chess.js
                    const myColor = this.colorForUser(authUserId) === 'white' ? COLOR.white : COLOR.black;
                    this.board.enableMoveInput((event) => {
                        this.error = '';
                        if (event.type === INPUT_EVENT_TYPE.moveInputStarted) {
                            if (this.game.game_over() || !this.isUsersTurn()) return false;
                            return true;
                        }
                        if (event.type === INPUT_EVENT_TYPE.validateMoveInput) {
                            const from = event.squareFrom;
                            const to = event.squareTo;
                            const fenBefore = this.fen;
                            const move = this.game.move({ from, to, promotion: 'q' });
                            if (!move) {
                                this.error = '{{ __('حرکت نامعتبر است') }}';
                                return false; // snap back
                            }
                            this.fen = this.game.fen();
                            // Reflect on board
                            this.board.setPosition(this.fen, true);

                            // Update move list (UI only)
                            const li = document.createElement('li');
                            li.textContent = move.san;
                            document.getElementById('moveList').appendChild(li);

                            // Persist via Livewire
                            const payload = {
                                from,
                                to,
                                san: move.san,
                                fen_before: fenBefore,
                                fen_after: this.fen,
                                meta: { check: this.game.in_check(), checkmate: this.game.in_checkmate(), draw: this.game.in_draw() }
                            };
                            $wire.saveMove(payload);
                            return true;
                        }
                        if (event.type === INPUT_EVENT_TYPE.moveInputCanceled) {
                            return true;
                        }
                    }, myColor);

                    // Subscribe to broadcast updates for this game
                    if (window.Echo) {
                        window.Echo.private('game.' + gameId)
                            .listen('.game.move', (e) => {
                                // Another player's move: update local board/FEN
                                if (e && e.fen) {
                                    this.fen = e.fen;
                                    this.game.load(e.fen);
                                    this.board.setPosition(e.fen, true);
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
                            this.board.setPosition(this.fen, true);
                        }
                    });
                },
            }
        }
    </script>
</div>
